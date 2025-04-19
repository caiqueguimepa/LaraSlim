<?php

use DI\Container;

use Dotenv\Dotenv;
use LaraSlim\Kernel\Kernel;
use Slim\Factory\AppFactory;


require __DIR__ . '/../vendor/autoload.php';

$container = new Container();
AppFactory::setContainer($container);
$app = AppFactory::create();

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$kernel = new Kernel();
$kernel->bootstrap($app);

return $app;