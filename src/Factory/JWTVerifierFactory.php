<?php

declare(strict_types=1);

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
        $config = $globalConfig['auth0']['jwt-verifier'];

        $validAudiences = $config['valid_audiences'];
        $authorizedIssuers = $config['authorized_issuers'];

        return new JWTVerifier(
            [
                'valid_audiences' => $validAudiences,
                'secret_base64_encoded' => false,
                'authorized_iss' => $authorizedIssuers,
                'supported_algs' => [
                    'RS256'
                ],
            ],
            $jwkFetcher
        );
    }
}
