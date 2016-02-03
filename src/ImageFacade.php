<?php

namespace IreIsaac\LaraImage;

use League\Glide\Server;
use Illuminate\Support\Facades\Facade;

/**
 * @see \League\Glide\Server
 */
class ImageFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return Server::class;
    }
}
