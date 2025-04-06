<?php


use SkeletonProjectPHP\Karnel\Console\Migration;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../bootstrap/dotenv.php';
require_once __DIR__ . '/../bootstrap/bootstrap.php';
require_once __DIR__ . '/../bootstrap/db.php';

Migration::loadMigrationFiles();

/** @var \Slim\Factory\AppFactory $app */
$app->run();