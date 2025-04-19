<?php

if (!function_exists('env')) {

    function env($key, $default = null)
    {
        if ($key === false) {
            $value = $_ENV[$key] ?? null;
        }

        return $value;
    }
}
if (!function_exists('app')){
    function app(?string $abstract = null)
    {
        global $container;

        if ($abstract) {
            return $container->get($abstract);
        }

        return $container;
    }
}
