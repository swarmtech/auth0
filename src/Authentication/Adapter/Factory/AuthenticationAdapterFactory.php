<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\Authentication\Adapter\Factory;

use Laminas\Authentication\AuthenticationService;
use Psr\Container\ContainerInterface;
use Swarmtech\Auth0\Authentication\Adapter\IdTokenVerifierAdapter;
use Swarmtech\Auth0\MvcAuth\Adapter\AuthenticationAdapter;

/**
 * Class AuthenticationAdapterFactory
 *
 * @package Swarmtech\Auth0\Authentication\Adapter\Factory
 */
final class AuthenticationAdapterFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $idTokenVerifierAdapter = $container->get(IdTokenVerifierAdapter::class);
        $authenticationService = $container->get(AuthenticationService::class);

        return new AuthenticationAdapter(
            $idTokenVerifierAdapter,
            $authenticationService
        );
    }
}
