<?php
declare(strict_types=1);

namespace Swarmtech\Auth0;

use Swarmtech\Auth0\MvcAuth\Adapter\AuthenticationAdapter;
use Zend\Mvc\MvcEvent;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use ZF\MvcAuth\Authentication\DefaultAuthenticationListener;


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
