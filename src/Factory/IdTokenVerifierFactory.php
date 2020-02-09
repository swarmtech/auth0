<?php

declare(strict_types=1);

namespace Swarmtech\Auth0\Factory;

use Auth0\SDK\Helpers\Tokens\IdTokenVerifier;
use Auth0\SDK\Helpers\Tokens\SignatureVerifier;
use Psr\Container\ContainerInterface;

/**
 * Class IdTokenVerifierFactory
 * @package Swarmtech\Auth0\Factory
 */
final class IdTokenVerifierFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $signatureVerifier = $container->get(SignatureVerifier::class);

        $globalConfig = $container->get('config');
        $config = $globalConfig['auth0']['id-token-verifier'];

        $audience = $config['audience'];
        $issuer = $config['issuer'];

        return new IdTokenVerifier(
            $issuer,
            $audience,
            $signatureVerifier
        );
    }
}
