<?php

declare(strict_types=1);

namespace Swarmtech\Auth0;


final class ConfigProvider
{
    public function __invoke(): array
    {
        $laminasConfig = include __DIR__ . '/../config/module.config.php';
        $laminasConfig['dependencies'] = $laminasConfig['service_manager'];

        unset($laminasConfig['service_manager']);

        return $laminasConfig;
    }
}
