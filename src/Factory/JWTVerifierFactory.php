<?php

namespace Swarmtech\Auth0\Factory;

use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\JWTVerifier;
use Psr\Container\ContainerInterface;

/**
 * Class JWTVerifierFactory
 * @package Swarmtech\Auth0\Factory
 */
final class JWTVerifierFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $jwkFetcher = $container->get(JWKFetcher::class);

        $globalConfig = $container->get('config');
        $auth0Config = $globalConfig['auth0'];

        $validAudiences = explode(',', $auth0Config['valid_audiences']);
        $authorizedIssuers = $this->getAuthorizedIssuer($auth0Config);

        $config =  [
            'valid_audiences' => $validAudiences,
            'secret_base64_encoded' => false,
            'authorized_iss' => $authorizedIssuers,
            'supported_algs' => [
                'RS256'
            ]
        ];

        return new JWTVerifier($config, $jwkFetcher);
    }

    private function getAuthorizedIssuer(array $auth0Config)
    {
        if (isset($auth0Config['authorized_issuers'])) {
            return explode(',', $auth0Config['authorized_issuers']);
        }

        return [
            'https://' . $auth0Config['domain'] . '/'
        ];
    }
}
