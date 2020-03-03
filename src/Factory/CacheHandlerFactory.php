<?php

namespace Swarmtech\Auth0\Factory;

use Auth0\SDK\Helpers\Cache\FileSystemCacheHandler;
use Auth0\SDK\Helpers\Cache\NoCacheHandler;
use Predis\Client;
use Psr\Container\ContainerInterface;
use Swarmtech\Auth0\RedisCacheHandler;

/**
 * Class CacheHandlerFactory
 * @package Swarmtech\Auth0\Factory
 */
final class CacheHandlerFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $globalConfig = $container->get('config');
        $auth0Config = $globalConfig['auth0'];

        if (!isset($auth0Config['cache_handler'])) {
            return new NoCacheHandler();
        }

        $handler = $auth0Config['cache_handler'];

        if ($handler === RedisCacheHandler::class) {
            $client = $container->get(Client::class);

            return new RedisCacheHandler($client);
        }

        if ($handler === FileSystemCacheHandler::class) {
            return new FileSystemCacheHandler();
        }

        return new NoCacheHandler();
    }
}
