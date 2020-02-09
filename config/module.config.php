<?php

namespace Swarmtech\Auth0;

use Auth0\SDK\Helpers\Tokens\SignatureVerifier;
use Laminas\Authentication\AuthenticationService;
use Laminas\Authentication\Storage\NonPersistent;
use Laminas\ServiceManager\AbstractFactory\ConfigAbstractFactory;
use Swarmtech\Auth0\Authentication\Adapter\IdTokenVerifierAdapter;
use Swarmtech\Auth0\MvcAuth\Adapter\AuthenticationAdapter;
use Auth0\SDK\API\Authentication;
use Auth0\SDK\API\Helpers\ApiClient;
use Auth0\SDK\API\Management\Blacklists;
use Auth0\SDK\API\Management\ClientGrants;
use Auth0\SDK\API\Management\Clients;
use Auth0\SDK\API\Management\Connections;
use Auth0\SDK\API\Management\DeviceCredentials;
use Auth0\SDK\API\Management\Emails;
use Auth0\SDK\API\Management\EmailTemplates;
use Auth0\SDK\API\Management\Grants;
use Auth0\SDK\API\Management\Jobs;
use Auth0\SDK\API\Management\Logs;
use Auth0\SDK\API\Management\ResourceServers;
use Auth0\SDK\API\Management\Roles;
use Auth0\SDK\API\Management\Rules;
use Auth0\SDK\API\Management\Stats;
use Auth0\SDK\API\Management\Tenants;
use Auth0\SDK\API\Management\Tickets;
use Auth0\SDK\API\Management\UserBlocks;
use Auth0\SDK\API\Management\Users;
use Auth0\SDK\API\Management\UsersByEmail;
use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;
use Predis\Client;
use Swarmtech\Auth0\Factory\ApiClientFactory;
use Swarmtech\Auth0\Factory\AuthenticationFactory;
use Swarmtech\Auth0\Factory\IdTokenVerifierFactory;
use Swarmtech\Auth0\Factory\RedisClientFactory;
use Swarmtech\Auth0\MvcAuth\Factory\AuthenticationDelegatorFactory;
use Swarmtech\Auth0\MvcAuth\Listener\UnauthenticatedListener;
use Laminas\ServiceManager\AbstractFactory\ReflectionBasedAbstractFactory;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Laminas\ApiTools\MvcAuth\Authentication\DefaultAuthenticationListener;

return [
    'service_manager' => [
        'aliases' => [
            \Laminas\ApiTools\MvcAuth\UnauthenticatedListener::class => UnauthenticatedListener::class,
            'authentication' => AuthenticationService::class
        ],
        'factories' => [
            /** Auth0 */
            Authentication::class => AuthenticationFactory::class,
            ApiClient::class => ApiClientFactory::class,

            /** Auth0 JWT  */
            IdTokenVerifier::class => IdTokenVerifierFactory::class,
            JWKFetcher::class => ConfigAbstractFactory::class,
            SignatureVerifier::class => ConfigAbstractFactory::class,

            /** Auth0 Resource */
            Blacklists::class => ReflectionBasedAbstractFactory::class,
            ClientGrants::class => ReflectionBasedAbstractFactory::class,
            Clients::class => ReflectionBasedAbstractFactory::class,
            Connections::class => ReflectionBasedAbstractFactory::class,
            DeviceCredentials::class => ReflectionBasedAbstractFactory::class,
            Emails::class => ReflectionBasedAbstractFactory::class,
            EmailTemplates::class => ReflectionBasedAbstractFactory::class,
            Grants::class => ReflectionBasedAbstractFactory::class,
            Jobs::class => ReflectionBasedAbstractFactory::class,
            Logs::class => ReflectionBasedAbstractFactory::class,
            ResourceServers::class => ReflectionBasedAbstractFactory::class,
            Roles::class => ReflectionBasedAbstractFactory::class,
            Rules::class => ReflectionBasedAbstractFactory::class,
            Stats::class => ReflectionBasedAbstractFactory::class,
            Tenants::class => ReflectionBasedAbstractFactory::class,
            Tickets::class => ReflectionBasedAbstractFactory::class,
            UserBlocks::class => ReflectionBasedAbstractFactory::class,
            Users::class => ReflectionBasedAbstractFactory::class,
            UsersByEmail::class => ReflectionBasedAbstractFactory::class,

            /** MvcAuth */
            AuthenticationService::class => ConfigAbstractFactory::class,
            UnauthenticatedListener::class => InvokableFactory::class,
            AuthenticationAdapter::class => ConfigAbstractFactory::class,

            /** Redis */
            Client::class => RedisClientFactory::class,
        ],
        'delegators' => [
            DefaultAuthenticationListener::class => [
                AuthenticationDelegatorFactory::class
            ]
        ]
    ],
    ConfigAbstractFactory::class => [
        AuthenticationAdapter::class => [
            IdTokenVerifierAdapter::class,
            AuthenticationService::class
        ],
        AuthenticationService::class => [
            NonPersistent::class,
            IdTokenVerifierAdapter::class
        ],
        SignatureVerifier::class => [
            'RS256'
        ]
    ],
    'api-tools-mvc-auth' => [
        'authentication' => [
            'adapters' => [
                'auth0' => [
                    'adapter' => AuthenticationAdapter::class
                ]
            ]
        ]
    ]
];