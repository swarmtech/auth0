<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\Authentication\Adapter;

use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;
use Exception;
use Swarmtech\Auth0\MvcAuth\Identity\Auth0Identity;
use Laminas\Authentication\Adapter\AdapterInterface;
use Laminas\Authentication\Result;
use Laminas\Http\Request;
use Laminas\Http\Response;

/**
 * Class IdTokenVerifierAdapter
 *
 * Authentication Adapter for Auth0 Id Token Verifier
 *
 * @package Swarmtech\Auth0\Authentication\Adapter
 */
final class IdTokenVerifierAdapter implements AdapterInterface
{
    /**
     * @var IdTokenVerifier
     */
    private $idTokenVerifier;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param IdTokenVerifier $idTokenVerifier
     */
    public function __construct(IdTokenVerifier $idTokenVerifier)
    {
        $this->idTokenVerifier = $idTokenVerifier;
    }

    /**
     * Authenticates and provides an authentication result
     *
     * @return Result
     */
    public function authenticate()
    {
        $authorizationHeader = $this->request->getHeader('Authorization');
        $authorizationHeaderValue = $authorizationHeader->getFieldValue();

        list($clientScheme, $token) = explode(' ', $authorizationHeaderValue);
        $clientScheme = strtolower($clientScheme);

        if ($clientScheme != 'bearer') {
            return new Result(Result::FAILURE, null, [
                'Unsupported authentication scheme'
            ]);
        }

        try {
            // TODO: check that's
            $profile = $this->idTokenVerifier->verify($token);
        } catch (InvalidTokenException $e) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [
                $e->getMessage()
            ]);
        } catch (Exception $e) {
            return new Result(Result::FAILURE, null, [
                $e->getMessage()
            ]);
        }

        $identity = $this->getAuth0IdentityFromProfile($profile);

        return new Result(Result::SUCCESS, $identity);
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }

    private function getAuth0IdentityFromProfile($profile): Auth0Identity
    {
        $email = null;
        if ($profile->email_verified) {
            $email = $profile->email;
        }

        $givenName = null;
        if (isset($profile->given_name)) {
            $givenName = $profile->given_name;
        }

        $locale = null;
        if (isset($profile->locale)) {
            $locale = $profile->locale;
        }

        return new Auth0Identity(
            $profile->sub,
            $profile->name,
            $profile->picture,
            $profile->nickname,
            $locale,
            $givenName,
            $email
        );
    }
}
