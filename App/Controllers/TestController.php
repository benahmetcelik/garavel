<?php

namespace App\Controllers;


use Core\Controllers\BaseController;
use Core\QueryBuilder;

class TestController extends BaseController
{

    protected $prefix = 'test';


    /**
     * @throws \Exception
     */
    public function getTest()
    {

        $query = QueryBuilder::select(['id', 'name', 'email'],'users')->get();

        return response()->success($query)->send();
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