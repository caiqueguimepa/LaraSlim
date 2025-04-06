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