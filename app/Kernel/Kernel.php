<?php

namespace LaraSlim\Kernel;

use BladeSlim\Blade;
use LaraSlim\Kernel\Providers\AppServiceProvider;
use Slim\App;

class Kernel
{
    public function bootstrap(App $app): void
    {
        $this->registerMiddleware($app);
        $this->registerRoutes($app);
        $this->registerView($app);
        $this->registerAppServiceProvider($app);
    }

    protected function registerMiddleware(App $app): void
    {
        $app->addRoutingMiddleware();
        $app->addBodyParsingMiddleware();
    }

    protected function registerRoutes(App $app): void
    {
        require __DIR__ . './../../routes/web.php';
        require __DIR__ . '/../../routes/api.php';
    }

    protected function registerView(App $app): void
    {
        $blade = new Blade(
            __DIR__ . '/../../resources/views',
            __DIR__ . '/../../storage/cache',
            $app->getResponseFactory()->createResponse()
        );
        
    }
    protected function registerAppServiceProvider(App $app): void
    {
        $provider = new AppServiceProvider();
        $provider->register($app->getContainer());
    }
}