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

        $query = QueryBuilder::select('users', ['id', 'name', 'email']);
        $query->where('id', '=', 1);
        $result = $query->get();
        return $result;

//        $newQueryBuilder->select('users', ['id', 'name', 'email']);
//        $newQueryBuilder->where('id', '=', 1);
//        $result = $newQueryBuilder->get();
//        return $result;
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