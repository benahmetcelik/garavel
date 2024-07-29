<?php

namespace Controllers;

use ReflectionMethod;

class BaseController
{

    protected $prefix;


    public function response()
    {

    }


    /**
     * @throws \ReflectionException
     */
    public function getRoutes(): array
    {
        $thisClassFunctions = get_class_methods($this);
        unset($thisClassFunctions[array_search('getRoutes', $thisClassFunctions)]);
        $routes = [];
        foreach ($thisClassFunctions as $function) {
            $method = $this->findMethod($function);
            if (!$method) {
                continue;
            }
            $routes[] = $this->setRoute($function);
        }

        return $routes;

    }


    public function findMethod($function)
    {
        return $this->isStartWith($function, ['get', 'post']);
    }

    public function isStartWith($string, $array)
    {
        foreach ($array as $item) {
            $itemLength = strlen($item);
            $trimmedString = substr($string, 0, $itemLength);
            if ($trimmedString == $item) {
                return strtoupper($item);
            }
        }
        return false;
    }

    public function setRoute($function)
    {
        $method = new ReflectionMethod($this, $function);
        $parameters = $method->getParameters();
        return [
            'url' => '/'.$this->prefix . '/' . $this->camelToKebab(
                    $this->removeMethodOnTheFunc($function)
                ),
            'function' => $function,
            'params' => array_map(function ($param) {
                return $param->getName();
            }, $parameters),
            'paramCount' => count($parameters),
            'method' => $this->findMethod($function),
            'controller' => get_class($this),
        ];
    }


    public function removeMethodOnTheFunc($function): string
    {
        $getStart = $this->isStartWith($function, ['get', 'post']);
        if (!$getStart) {
            return $function;
        }
        return substr($function, strlen($getStart));
    }


    public function camelToKebab($input)
    {
        $pattern = '/([a-z0-9])([A-Z])/';
        $replacement = '$1-$2';
        $kebabCase = preg_replace($pattern, $replacement, $input);
        return strtolower($kebabCase);
    }
}