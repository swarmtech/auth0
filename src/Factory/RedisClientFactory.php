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

        if (!isset($globalConfig['redis']['auth0'])) {
            throw new \InvalidArgumentException('Redis configuration don\'t have auth0 key');
        }

        $config = $globalConfig['redis']['auth0'];
        $host = $config['host'];
        $port = $config['port'];

        return new Client([
            'alias' => 'auth0',
            'host' => $host,
            'port' => $port
        ]);
    }
}
