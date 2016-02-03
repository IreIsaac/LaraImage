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
        $router->get('img/{path}', function(Request $request, Server $glide) {

            return $glide->getImageResponse($request->getPathInfo(), $request->toArray());
        })->where('path', '.+');
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
