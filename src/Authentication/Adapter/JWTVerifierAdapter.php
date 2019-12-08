<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\Authentication\Adapter;

use Auth0\SDK\API\Management\Users;
use Auth0\SDK\Exception\CoreException;
use Auth0\SDK\Exception\InvalidTokenException;
use Auth0\SDK\JWTVerifier;
use Exception;
use Swarmtech\Auth0\MvcAuth\Identity\Auth0Identity;
use Zend\Authentication\Adapter\AdapterInterface;
use Zend\Authentication\Result;
use Zend\Http\Request;
use Zend\Http\Response;


/**
 * Class JWTVerifierAdapter
 *
 * Authentication Adapter for Auth0 JWT Verifier
 *
 * @package Swarmtech\Auth0\Authentication\Adapter
 */
class JWTVerifierAdapter implements AdapterInterface
{
    /**
     * @var JWTVerifier
     */
    private $jwtVerifier;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var Response
     */
    private $response;

    /**
     * @param JWTVerifier $jwtVerifier
     */
    public function __construct(JWTVerifier $jwtVerifier)
    {
        $this->jwtVerifier = $jwtVerifier;
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
            $decodedToken = $this->jwtVerifier->verifyAndDecode($token);
        } catch (InvalidTokenException $e) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [
                $e->getMessage()
            ]);
        } catch (CoreException $e) {
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, [
                $e->getMessage()
            ]);
        } catch (Exception $e) {
            return new Result(0, null, [
                $e->getMessage()
            ]);
        }

        $identity = new Auth0Identity($decodedToken);
        $result = new Result(Result::SUCCESS, $identity);

        return $result;
    }

    public function setRequest(Request $request)
    {
        $this->request = $request;
    }

    public function setResponse(Response $response)
    {
        $this->response = $response;
    }
}
