<?php
require 'vendor/autoload.php';
require 'Core/core.php';
use App\Classes\Handler;
use App\Classes\Request;
use App\Classes\Router;

define('PROCESS_START', microtime(true));
ini_set('display_errors', 1);

$request = new Request();
$routes = new Router($request);
$handler = new Handler();

$handler->terminate(function () use ($routes) {
    return $routes->callAction();
});

