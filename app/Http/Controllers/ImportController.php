<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;

class ImportController extends BaseController
{

    public function index() {

        /*If DB data is not present OR if it does not link to a invoiceplane DB -> fail*/

        try {

            DB::connection()->getPdo();

            return view('index');

        }
        catch(\Exception $e) {

            return view('db_fail', ['message' => $e->getMessage()]);
        }

    }

    public function crunch() {

        $class = Input::get('class');

        echo $class;
    }

}