<?php


use LaraSlim\Karnel\Console\Migration;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/dotenv.php';
require_once __DIR__ . '/../bootstrap/bootstrap.php';
require_once __DIR__ . '/../config/hellpers/functions.php';

Migration::loadMigrationFiles();

/** @var \Slim\Factory\AppFactory $app */
$app->run();