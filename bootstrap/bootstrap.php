<?php


use DI\Container;
use LaraSlim\Karnel\Providers\AppServiceProvider;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Slim\Factory\AppFactory;


$container = new Container();

$provider = new AppServiceProvider();
$provider->register($container);

AppFactory::setContainer($container);
$app = AppFactory::create();

$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {

    $response->getBody()->write(json_encode([
        'status' => 'success',
        'message' => 'Welcome to the API',
        'data' => [
            'version' => '1.0.0',
            'author' => 'Caique Bispo',
            'description' => 'This is a sample API built with Slim Framework.',
        ],
    ]));

    return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(200);
});

require_once __DIR__ . './../routes/api.php';