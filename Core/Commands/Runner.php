<?php

namespace Core\Commands;

use JetBrains\PhpStorm\NoReturn;

class Runner
{
    public $commands = [];

    #[NoReturn] public function __construct($argv = null,$options = null)
    {
        $runStatus = 0;
        $this->loadSystemCommands();
        $this->loadCustomCommands();
        $command = $this->findCommand($argv);
        if ($command) {
           $runStatus = $command->run($options);
            echo "\n";
        } else {
            echo "Command not found\n";
            echo $argv . "\n";
        }
        if ($runStatus !== 0) {
            exit($runStatus);
        }

        exit(0);
    }


    public function findCommand($command_signature)
    {
        if (isset($this->commands[$command_signature])) {
            return $this->commands[$command_signature];
        }
        return null;
    }

    public function loadCustomCommands(): void
    {
        $commandsPath = app_path('Commands/');
        $this->loadCommands($commandsPath,'App\\Commands\\' );
    }

    public function loadSystemCommands(): void
    {
        $commandsPath = core_path('Commands/SystemCommands/');
        $this->loadCommands($commandsPath,'Core\\Commands\\SystemCommands\\' );
    }

    public function loadCommands($commandsPath,$namespace): void
    {
        $files = scandir($commandsPath);
        foreach ($files as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            }
            $commandFile = require_once $commandsPath . $file;
            $callClass = $namespace. str_replace('.php', '', $file);
            $command = new $callClass;
            $this->commands[$command->signature] = $command;
        }
    }

    public function getCommands()
    {
        return $this->commands;
    }

}