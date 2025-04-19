<?php

/** @var \Slim\Factory\AppFactory $app */

use LaraSlim\Http\Controllers\UserController;
use Slim\Routing\RouteCollectorProxy;

$app->group('/api/v1', function (RouteCollectorProxy $group) {

    $group->get('/users', [UserController::class, 'index']);
    $group->post('/users', [UserController::class, 'store']);
    $group->get('/users/{id}', [UserController::class, 'show']);
    $group->put('/users/{id}', [UserController::class, 'update']);
    $group->delete('/users/{id}', [UserController::class, 'delete']);
});
