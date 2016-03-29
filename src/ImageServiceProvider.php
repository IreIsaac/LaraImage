<?php

namespace IreIsaac\LaraImage;

use League\Glide\Server;
use Illuminate\Http\Request;
use League\Glide\ServerFactory;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Routing\Registrar;
use Illuminate\Contracts\Filesystem\Filesystem;
use League\Glide\Responses\LaravelResponseFactory;

class ImageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(Registrar $router)
    {
        // Register the default route for images
        $router->get('img/{path}', function(Request $request, Server $glide) {

            return $glide->getImageResponse($request->getPathInfo(), $request->all());
        })->where('path', '.+'); // match all routes where path starts with img/

        // configuration file
        $this->publishes([
            __DIR__.'/../config/images.php' => config_path('images.php')
        ], 'config');

        // default images
        $this->publishes([
            __DIR__.'/../storage/' => storage_path('app/images')
        ], 'images');

    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(Server::class, function ($app) {

            return ServerFactory::create([
                    'response'           => new LaravelResponseFactory(),
                    'source'             => $app[Filesystem::class]->getDriver(),
                    'cache'              => $app[Filesystem::class]->getDriver(),
                    'source_path_prefix' => 'images',
                    'cache_path_prefix'  => 'images/.cache',
                    'base_url'           => 'img'
                ]);
        });
    }
}
