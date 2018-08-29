<?php

namespace Soumen\Auction\Facades;

use Illuminate\Support\Facades\Facade;

class Auction extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'auction';
    }
}
