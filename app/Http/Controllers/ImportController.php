<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Product;
use App\Plane2Ninja\Ninja\NinjaFactory;
use App\Plane2Ninja\Transformers\ClientTransformer;
use App\Plane2Ninja\Transformers\InvoiceItemTransformer;
use App\Plane2Ninja\Transformers\InvoiceTransformer;
use App\Plane2Ninja\Transformers\PaymentTransformer;
use App\Plane2Ninja\Transformers\ProductTransformer;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

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

    public function crunch($className) {

        $clients = Client::with('invoices', 'invoices.items', 'invoices.payments')->get();

        $ninjaFactory = new NinjaFactory(new ClientTransformer(), new InvoiceTransformer(), new PaymentTransformer(), new InvoiceItemTransformer(), new ProductTransformer());

        $data['clients'] = $ninjaFactory->buildNinja($clients);
        $data['products'] = $ninjaFactory->buildProducts(Product::all());

        echo json_encode($data, JSON_PRETTY_PRINT);

    }



}