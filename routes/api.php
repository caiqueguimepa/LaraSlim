<?php


/** @var \Slim\Factory\AppFactory $app */


use SkeletonProjectPHP\Http\Controllers\UserController;
use Slim\Routing\RouteCollectorProxy;

$app->group('/api/v1', function (RouteCollectorProxy $group){

    $group->get('/users', [UserController::class, 'index']);
    $group->post('/users', [UserController::class, 'store']);
    $group->get('/users/{id}', UserController::class, 'find');
    $group->put('/users/{id}', UserController::class, 'update');
    $group->delete('/users/{id}', UserController::class, 'delete');
});