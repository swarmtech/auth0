<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\Factory;

use Auth0\SDK\Helpers\JWKFetcher;
use Auth0\SDK\Helpers\Tokens\AsymmetricVerifier;
use Psr\Container\ContainerInterface;

/**
 * Class AsymmetricVerifierFactory
 *
 * @package Swarmtech\Auth0\Factory
 */
final class AsymmetricVerifierFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $globalConfig = $container->get('config');
        $auth0Config = $globalConfig['auth0'];
        $idTokenVerifier = $auth0Config['id-token-verifier'];
        $jwksUrl = $idTokenVerifier['issuer'].'.well-known/jwks.json';

        $jwkFetcher = $container->get(JWKFetcher::class);
        $jwks = $jwkFetcher->getKeys($jwksUrl);

        return new AsymmetricVerifier($jwks);
    }
}
