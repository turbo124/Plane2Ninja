<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;

class ImportController extends BaseController
{

    public function index() {

        /*If DB data is not present OR if it does not link to a invoiceplane DB -> fail*/


        return view('index');
    }
}