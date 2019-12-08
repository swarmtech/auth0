<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\MvcAuth\Adapter;

use Swarmtech\Auth0\Authentication\Adapter\JWTVerifierAdapter;
use Zend\Http\Request;
use Zend\Http\Response;
use ZF\MvcAuth\Identity\GuestIdentity;
use ZF\MvcAuth\Identity\IdentityInterface;
use ZF\MvcAuth\MvcAuthEvent;
use ZF\MvcAuth\Authentication\AbstractAdapter;
use Zend\Authentication\AuthenticationServiceInterface;

/**
 * Class AuthenticationAdapter
 *
 * @package Swarmtech\Auth0\MvcAuth\Adapter
 */
class AuthenticationAdapter extends AbstractAdapter
{
    const AUTH0 = 'auth0';

    /**
     * @var array
     */
    private static $handledTypes = [
        self::AUTH0
    ];

    /**
     * @var AuthenticationServiceInterface
     */
    private $authenticationService;

    /**
     * @var JWTVerifierAdapter
     */
    private $jwtVerifierAdapter;

    /**
     * @param JWTVerifierAdapter $jwtVerifierAdapter
     * @param AuthenticationServiceInterface $authenticationService
     */
    public function __construct(
        JWTVerifierAdapter $jwtVerifierAdapter,
        AuthenticationServiceInterface $authenticationService
    ) {
        $this->jwtVerifierAdapter = $jwtVerifierAdapter;
        $this->authenticationService = $authenticationService;
    }

    /**
     * Returns the "types" this adapter can handle.
     *
     * @return array Array of types this adapter can handle.
     */
    public function provides(): array
    {
        return self::$handledTypes;
    }

    /**
     * Match the requested authentication type against what we provide.
     *
     * @param string $type
     * @return bool
     */
    public function matches($type): bool
    {
        return $type === self::AUTH0;
    }

    /**
     * Perform pre-flight authentication operations.
     *
     * Performs a no-op; nothing needs to happen for this adapter.
     *
     * @param Request $request
     * @param Response $response
     */
    public function preAuth(Request $request, Response $response)
    {
    }

    /**
     * Attempt to authenticate the current request.
     *
     * @param Request $request
     * @param Response $response
     * @param MvcAuthEvent $mvcAuthEvent
     * @return IdentityInterface False on failure, IdentityInterface otherwise
     */
    public function authenticate(Request $request, Response $response, MvcAuthEvent $mvcAuthEvent)
    {
        if (!$request->getHeader('Authorization', false)) {
            return new GuestIdentity();
        }

        $this->jwtVerifierAdapter->setRequest($request);
        $this->jwtVerifierAdapter->setResponse($response);

        $result = $this->authenticationService->authenticate();
        $mvcAuthEvent->setAuthenticationResult($result);

        if (!$result->isValid()) {
            return new GuestIdentity();
        }

        return $result->getIdentity();
    }
}
