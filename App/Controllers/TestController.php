<?php

namespace Controllers;



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

}