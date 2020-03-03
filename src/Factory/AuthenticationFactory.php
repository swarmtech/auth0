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
        $auth0config = $globalConfig['auth0'];

        $domain = $auth0config['domain'];
        $clientId = $auth0config['client_id'];
        $clientSecret = $auth0config['client_secret'];

        return new Authentication($domain, $clientId, $clientSecret);
    }
}
