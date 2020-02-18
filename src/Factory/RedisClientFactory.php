<?php

namespace Swarmtech\Auth0\Factory;

use Predis\Client;
use Psr\Container\ContainerInterface;

/**
 * Class RedisClientFactory
 * @package Swarmtech\Auth0\Factory
 */
final class RedisClientFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $globalConfig = $container->get('config');

        $alias = 'auth0-jwk-fetcher-cache';
        $config = $globalConfig['redis'][$alias];
        $host = $config['host'];
        $port = $config['port'];

        return new Client([
            'alias' => $alias,
            'host' => $host,
            'port' => $port
        ]);
    }
}
