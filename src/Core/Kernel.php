<?php

namespace Src\Core;

class Kernel
{
    /**
     * The application implementation.
     *
     * @var App
     */
    protected $app;

    /**
     * Global middleware, middleware for all routes
     *
     * @var array
     */
    protected $middleware;

    protected $routeMiddleware;

    /**
     * The bootstrap classes for the application.
     *
     * @var array
     */
    protected $bootstrappers = [
        \Src\Alias\Bootstrap\RegisterFacades::class,
    ];

    public function __construct(App $app)
    {
        $this->app = $app;
    }

    /**
     * Bootstrap the application for HTTP/WebSocket/RPC requests.
     *
     * @return void
     */
    public function bootstrap()
    {
        if (!$this->app->hasBeenBootstrapped()) {
            $this->app->bootstrapWith($this->bootstrappers());
        }
    }

    /**
     * Active the application.
     *
     * @return void
     */
    public function active()
    {
        if (!$this->app->hasBeenActived()) {
            $this->app->activeWith($this->needActiveProviders());
        }
    }

    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    public function getRouteMiddleware(string $key): string
    {
        return isset($this->routeMiddleware[$key]) ? $this->routeMiddleware[$key] : '';
    }

    /**
     * Get the bootstrap classes for the application.
     *
     * @return array
     */
    protected function bootstrappers()
    {
        return $this->bootstrappers;
    }

    /**
     * Get the need active providers classes for the application.
     *
     * @return array
     */
    protected function needActiveProviders()
    {
        return $this->needActiveProviders;
    }

    /**
     * Get the Laravel application instance.
     *
     * @return App
     */
    public function getApp()
    {
        return $this->app;
    }
}
