<?php

namespace Core\Commands\SystemCommands\Routes;

use Core\Commands\Base\BaseCommand;
use Core\Router\Router;

class RouteCommand extends BaseCommand
{


    /**
     * Your command signature
     * @var string Command signature
     */
    public $signature = 'route:list';

    /**
     * Your command description
     * @var string Command description
     */
    public $description = 'List all routes';

    /**
     * Your command handler
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        $router = new Router();
        $routes = $router->getRoutes();
        $rows = [];
        foreach ($routes as $route) {
            $rows[] = [
                $route['method'],
                $route['url'],
                $route['function'],
                $route['controller']
            ];
        }
        $this->table(['Method', 'URL', 'Function', 'Controller'], $rows);
    }
}