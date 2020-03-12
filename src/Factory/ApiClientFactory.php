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
        /** @var Authentication $authentication */
        $authentication = $container->get(Authentication::class);

        $globalConfig = $container->get('config');
        $auth0Config = $globalConfig['auth0'];
        $version = $this->getAuth0Version($auth0Config);
        $domain = 'https://' . $auth0Config['domain'] . '/api/' . $version . '/';

        $response = $authentication->client_credentials([
            'audience' => $domain
        ]);

        $accessToken = $response['access_token'];

        return new ApiClient([
            'basePath' => '',
            'domain' => $domain,
            'guzzleOptions' => [
                'headers' => [
                    'Authorization' => 'Bearer ' . $accessToken
                ]
            ]
        ]);
    }

    private function getAuth0Version(array $auth0Config)
    {
        if (!isset($auth0Config['version'])) {
            return 'v2';
        }

        return $auth0Config['version'];
    }
}
