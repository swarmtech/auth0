<?php

namespace Swarmtech\Auth0\Factory;

use Auth0\SDK\API\Authentication;
use Auth0\SDK\API\Helpers\ApiClient;
use Psr\Container\ContainerInterface;

/**
 * Class ApiClientFactory
 * @package Swarmtech\Auth0\Factory
 */
final class ApiClientFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $globalConfig = $container->get('config');
        $config = $globalConfig['auth0']['client'];
        $domain = $config['domain'];

        /** @var Authentication $authentication */
        $authentication = $container->get(Authentication::class);

        $response = $authentication->client_credentials([
            'audience' => $domain
        ]);

        $accessToken = $response['access_token'];

        return new ApiClient([
            'basePath' => '',
            'domain' => $domain,
            'guzzleOptions' => [
                'headers' => [
                    'Authorization' => 'Bearer '. $accessToken
                ]
            ]
        ]);
    }
}
