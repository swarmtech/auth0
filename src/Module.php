<?php

declare(strict_types=1);

namespace Swarmtech\Auth0;

use Swarmtech\Auth0\MvcAuth\Adapter\AuthenticationAdapter;
use Laminas\Mvc\MvcEvent;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Laminas\ApiTools\MvcAuth\Authentication\DefaultAuthenticationListener;


/**
 * Class Module
 *
 * @package Swarmtech\Auth0
 */
final class Module
{
    public function getConfig(): array
    {
        $provider = new ConfigProvider();

        return [
            'service_manager' => $provider->getDependencyConfig(),
            ConfigAbstractFactory::class => $provider->getConfigAbstractFactoryConfig(),
            'api-tools-mvc-auth' => $provider->getApiToolsMvcAuthConfig()
        ];
    }

    public function onBootstrap(MvcEvent $mvcEvent)
    {
        $application = $mvcEvent->getApplication();
        $events = $application->getEventManager();
        $container = $application->getServiceManager();

        $events->attach(
            'authentication',
            function ($mvcEvent) use ($container) {
                $listener = $container->get(DefaultAuthenticationListener::class);
                $adapter = $container->get(AuthenticationAdapter::class);

                $listener->attach($adapter);
            },
            1000
        );
    }
}
