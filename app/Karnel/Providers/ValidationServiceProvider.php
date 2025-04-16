<?php

namespace LaraSlim\Karnel\Providers;

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Illuminate\Translation\Translator;
use Illuminate\Validation\DatabasePresenceVerifier;
use Illuminate\Validation\Factory;
use Psr\Container\ContainerInterface;

class ValidationServiceProvider
{
    public function register(ContainerInterface $container): void
    {
        /** @phpstan-ignore method.notFound */
        $container->set(Factory::class, function () use ($container) {
            $loader = new FileLoader(
                new Filesystem(),
                __DIR__.'/../../resources/lang'
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
