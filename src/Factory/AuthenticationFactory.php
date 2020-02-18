<?php

namespace Swarmtech\Auth0\Factory;

use Auth0\SDK\API\Authentication;
use Psr\Container\ContainerInterface;

/**
 * Class AuthenticationFactory
 * @package Swarmtech\Auth0\Factory
 */
final class AuthenticationFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $globalConfig = $container->get('config');
        $config = $globalConfig['auth0']['authentication'];

        $domain = $config['domain'];
        $clientId = $config['client_id'];
        $clientSecret = $config['client_secret'];

        return new Authentication($domain, $clientId, $clientSecret);
    }
}
