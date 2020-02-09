<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\MvcAuth\Factory;

use Interop\Container\ContainerInterface;
use Swarmtech\Auth0\MvcAuth\Adapter\AuthenticationAdapter;
use Laminas\ServiceManager\Factory\DelegatorFactoryInterface;

/**
 * Class AuthenticationDelegatorFactory
 * @package Swarmtech\Auth0\MvcAuth\Factory
 */
final class AuthenticationDelegatorFactory implements DelegatorFactoryInterface
{
    public function __invoke(ContainerInterface $container, $name, callable $callback, array $options = null)
    {
        /** @var AuthenticationAdapter $auth0Adapter */
        $authenticationAdapter = $container->get(AuthenticationAdapter::class);

        $listener = $callback();
        $listener->attach($authenticationAdapter);

        return $listener;
    }
}
