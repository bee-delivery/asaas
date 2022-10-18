<?php

namespace luanrodrigues\asaas\Facades;

use Illuminate\Support\Facades\Facade;

class Asaas extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'asaas';
    }
}
