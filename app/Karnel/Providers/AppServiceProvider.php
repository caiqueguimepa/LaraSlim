<?php

namespace LaraSlim\Karnel\Providers;

use Psr\Container\ContainerInterface;

class AppServiceProvider
{
    public function register(ContainerInterface $container): void
    {
        $providers = $this->loadProvider();

        foreach ($providers['providers'] as $providerClass) {
            $provider = new $providerClass();
            $provider->register($container);
        }
    }

    /**
     * Load the application configuration.
     *
     * @return array<string, mixed>
     */
    private function loadProvider(): array
    {
        return require_once __DIR__.'./../../../config/app.php';
    }
}
