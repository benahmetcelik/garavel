<?php

namespace Core\Commands\Base;

class BaseCommand implements IBaseCommandInterface
{

    public $options;

    public function __construct()
    {
        $this->getOptions();
    }

    public function run()
    {
        // TODO: Implement run() method.
    }

    public function option($key)
    {
        global $argv;
        $optionKey = array_search($key, $this->options);
        if ($optionKey === false) {
            throw new \Exception('Argument not found : ' . $key);
        }
        if (isset($argv[$optionKey + 2])) {
            return $argv[$optionKey + 2];
        }
        return null;
    }

    public function getOptions()
    {
        $signature = $this->signature;
        $signature = explode(' ', $signature);
        $options = [];
        foreach ($signature as $key => $value) {
            if (strpos($value, '{') !== false) {
                $value = str_replace('{', '', $value);
                $value = str_replace('}', '', $value);
                $options[] = $value;
            }
        }
        $this->options = $options;
        return $options;
    }
}