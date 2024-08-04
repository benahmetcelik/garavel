<?php

namespace App\Controllers;


use App\Models\UserModel;
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
        try {
            $user = (new \App\Models\UserModel)->find(5);
            return response()->success($user)->send();
        }catch (\Exception $e) {
            return response()->error($e->getMessage())->send();
        }

        $user = UserModel::where('id', '=', 1)->get();
        return response()->success($user)->send();
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