<?php

declare(strict_types=1);

namespace Swarmtech\Auth0;

use Auth0\SDK\Helpers\Cache\CacheHandler;
use Predis\Client;
use Swarmtech\Auth0\Factory\CacheHandlerFactory;
use Swarmtech\Auth0\Factory\RedisClientFactory;

return [
    'service_manager' => [
        'factories' => [
            /** Auth0 CacheHandler */
            CacheHandler::class => CacheHandlerFactory::class,

            /** Redis */
            Client::class => RedisClientFactory::class,
        ],
    ]
];


