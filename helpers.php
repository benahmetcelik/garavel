<?php


use Illuminate\Container\Container;

use Illuminate\Events\Dispatcher;
use Jenssegers\Blade\Blade;


function request($key = null, $method = 'get')
{
    $request = $GLOBALS['request'];
    if ($key == null) {
        return $request;
    }
    return $request->{$method}($key);
}


