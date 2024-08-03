<?php

namespace App\Commands;

use Core\Commands\Base\BaseCommand;

class PingCommand extends BaseCommand
{


    public $signature = 'ping';

    public function run()
    {
        echo 'PONG';
    }

}

