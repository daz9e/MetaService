<?php

namespace App\Services\Meta\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void set(string $param, $value)
 * @method static void get(string $param, $defaultValue = null)
 */
class Meta extends Facade
{
    /**
     * Name of the binding in the IoC container
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'meta';
    }
}
