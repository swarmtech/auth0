<?php

declare(strict_types=1);

namespace Swarmtech\Auth0;

use Predis\Client;
use Swarmtech\Auth0\Factory\RedisClientFactory;

return [
    'service_manager' => [
        'factories' => [
            Client::class => RedisClientFactory::class
        ]
    ]
];


