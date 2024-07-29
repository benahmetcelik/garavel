<?php

namespace Core\Router;
use App\Classes\Request;
use App\Classes\Response;

class Router
{
    protected $routes;
    protected $method;
    protected $url;
    protected $query;
    protected $body;

    protected $request;
    protected $response;
    public function __construct()
    {
        $this->response = new Response();
        $this->method = request()->method();
        $this->url = request()->url();
        $this->query = request()->query();
        $this->body = request()->body();
        $controllersDir =app_path('Controllers');
        $controllers = scandir($controllersDir);
        foreach ($controllers as $controller) {
            if ($controller == '.' || $controller == '..') {
                continue;
            }
            $controllerPath = app_path('Controllers/'.$controller) ;
            require_once $controllerPath;
            $controllerClass = 'App\\Controllers\\' . pathinfo($controller, PATHINFO_FILENAME);
            if (class_exists($controllerClass)) {
                $this->routes[] = (new $controllerClass)->getRoutes();
            }
        }
        $this->loadStaticRoutes();
    }




    public function getRoutes($method=null): array
    {
        $routes = $this->routes;
        $routes = array_merge(...$routes);
        return array_filter($routes, function($value) use ($method){
            $temp = true;
            if ($method) {
               $temp = $value['method'] == $method;
            }
            return !is_null($value) && $value !== '' && $value !== [] && $temp;
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
                if (array_key_exists('callback', $route)) {
                    return $route['callback']($this->query, $this->body);
                }
                $controller = new $route['controller'];
                $action = $route['function'];
                return $controller->$action($this->query, $this->body);
            }
        }
    }

    protected function loadStaticRoutes()
    {
        $this->routes[] = [];
    }

}