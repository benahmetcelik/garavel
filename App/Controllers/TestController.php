<?php

namespace App\Controllers;



use Core\Controllers\BaseController;

class TestController extends BaseController
{

    protected $prefix = 'test';


    /**
     * @throws \Exception
     */
    public function getTest()
    {
        return view('pages.home', ['name' => 'Test']);
    }


    /**
     * @throws \Exception
     */
    public function getTemplate()
    {
        return template('HomeTemplate', ['name' => 'Test']);

    }

}