<?php

declare(strict_types=1);

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

        if (!isset($globalConfig['auth0']['cache']['handler'])) {
            return new NoCacheHandler();
        }

        $handler = $globalConfig['auth0']['cache']['handler'];

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
