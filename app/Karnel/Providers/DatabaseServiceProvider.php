<?php

namespace LaraSlim\Karnel\Providers;

use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Container\ContainerInterface;
class DatabaseServiceProvider
{
    public function register(ContainerInterface $container): void
    {
        $capsule = new Capsule;

        $capsule->addConnection([
            'driver' => env('DB_CONNECTION'),
            'host' => env('DB_HOST'),
            'database' => env('DB_DATABASE'),
            'username' => env('DB_USERNAME'),
            'password' => env('DB_PASSWORD'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]);

        $capsule->setAsGlobal();
        $capsule->bootEloquent();
        /** @phpstan-ignore method.notFound */
        $container->set(Capsule::class, fn () => $capsule);
    }
}