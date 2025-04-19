<?php


use BladeSlim\Blade;
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

$app->addBodyParsingMiddleware();
$blade = new Blade(
    __DIR__ . '/../resources/views',
    __DIR__ . '/../storage/cache',
    $app->getResponseFactory()->createResponse()
);

$app->get('/', function (ServerRequestInterface $request, ResponseInterface $response, array $args) {
    
    return view('welcome');
});

require_once __DIR__ . './../routes/api.php';