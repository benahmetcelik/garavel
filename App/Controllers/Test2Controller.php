<?php

namespace App\Controllers;

use Core\Controllers\BaseController;

class Test2Controller extends BaseController
{

    protected $prefix = 'test2';


    public function postTest3($adi)
    {
        return 'test';
    }

}