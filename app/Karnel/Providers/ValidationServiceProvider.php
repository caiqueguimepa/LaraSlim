<?php

namespace LaraSlim\Karnel\Providers;

use Illuminate\Validation\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Database\Capsule\Manager as Capsule;
use Psr\Container\ContainerInterface;

class ValidationServiceProvider
{
    public function register(ContainerInterface $container): void
    {
        $container->set(Factory::class, function () use ($container) {
            $loader = new FileLoader(
                new Filesystem,
                __DIR__ . '/../../resources/lang'
            );

            $translator = new Translator($loader, 'pt_BR');

            $validator = new Factory($translator);

            $capsule = $container->get(Capsule::class);
            $presenceVerifier = new DatabasePresenceVerifier($capsule->getDatabaseManager());
            $validator->setPresenceVerifier($presenceVerifier);

            return $validator;
        });
    }
}
