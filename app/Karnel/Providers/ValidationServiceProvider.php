<?php

namespace LaraSlim\Karnel\Providers;

use Illuminate\Validation\Factory;
use Illuminate\Translation\Translator;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Translation\FileLoader;
use Psr\Container\ContainerInterface;

class ValidationServiceProvider
{
    public static function register(ContainerInterface $container)
    {
        $container->set('validator', function () {
            $loader = new FileLoader(
                new Filesystem,
                __DIR__.'./../../resources/lang'
            );

            $translator = new Translator($loader, 'pt_BR');

            return new Factory($translator);
        });
    }
}