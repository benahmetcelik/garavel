<?php

namespace App\Classes;
class Router
{
    protected $routes;
    protected $method;
    protected $url;
    protected $query;
    protected $body;

    protected $response;
    public function __construct(Request $request)
    {
        $this->response = new Response();
        $this->method = $request->method();
        $this->url = $request->url();
        $this->query = $request->query();
        $this->body = $request->body();
        $controllersDir = __DIR__ . '/../Controllers';
        $controllers = scandir($controllersDir);

        foreach ($controllers as $controller) {
            if ($controller == '.' || $controller == '..') {
                continue;
            }
            $controllerPath = $controllersDir . '/' . $controller;
            require_once $controllerPath;
            $controllerClass = 'Controllers\\' . pathinfo($controller, PATHINFO_FILENAME);
            if (class_exists($controllerClass)) {
                $this->routes[] = (new $controllerClass)->getRoutes();
            }
        }
    }


    public function getRoutes(): array
    {
        $routes = $this->routes;
        $routes = array_merge(...$routes);
        return array_filter($routes, function($value){
            return !is_null($value) && $value !== '' && $value !== [];
        });
    }

    public function callAction()
    {
        $routes = $this->getRoutes();
        $routes = array_filter($routes,function ($route){
            return $route['url'] == $this->url && $route['method'] == $this->method;
        });





        if (empty($routes)) {
            $this->response->notFound();
        }


        foreach ($routes as $route) {
            if ($route['url'] == $this->url && $route['method'] == $this->method) {

                $controller = new $route['controller'];
                $action = $route['function'];
                return $controller->$action($this->query, $this->body);
            }
        }

    }

}