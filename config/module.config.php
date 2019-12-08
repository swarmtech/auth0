<?php

declare(strict_types=1);

namespace Swarmtech\Auth0;

use Auth0\SDK\API\Authentication;
use Auth0\SDK\API\Helpers\ApiClient;
use Auth0\SDK\Helpers\Cache\CacheHandler;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\JWTVerifier;
use Predis\Client;
use Swarmtech\Auth0\Factory\ApiClientFactory;
use Swarmtech\Auth0\Factory\AuthenticationFactory;
use Swarmtech\Auth0\Factory\CacheHandlerFactory;
use Swarmtech\Auth0\Factory\JWTVerifierFactory;
use Swarmtech\Auth0\Factory\RedisClientFactory;
use Zend\ServiceManager\AbstractFactory\ConfigAbstractFactory;

return [
    'service_manager' => [
        'factories' => [
            /** Auth0 */
            Authentication::class => AuthenticationFactory::class,
            ApiClient::class => ApiClientFactory::class,

            /** Auth0 JWT  */
            JWTVerifier::class => JWTVerifierFactory::class,
            JWKFetcher::class => ConfigAbstractFactory::class,

            /** Auth0 CacheHandler */
            CacheHandler::class => CacheHandlerFactory::class,

            /** Redis */
            Client::class => RedisClientFactory::class,
        ]
    ],
    ConfigAbstractFactory::class => [
        JWKFetcher::class => [
            CacheHandler::class
        ]
    ]
];


