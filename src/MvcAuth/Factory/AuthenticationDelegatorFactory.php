<?php

namespace Swarmtech\Auth0\MvcAuth\Factory;

use Interop\Container\ContainerInterface;
use Swarmtech\Auth0\MvcAuth\Adapter\AuthenticationAdapter;
use Zend\ServiceManager\Factory\DelegatorFactoryInterface;

class AuthenticationDelegatorFactory implements DelegatorFactoryInterface
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
