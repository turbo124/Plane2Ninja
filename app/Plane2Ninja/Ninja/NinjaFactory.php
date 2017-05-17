<?php

namespace App\Plane2Ninja\Ninja;

use App\Models\Client;
use App\Plane2Ninja\Transformers\ClientTransformer;
use App\Plane2Ninja\Transformers\InvoiceItemTransformer;
use App\Plane2Ninja\Transformers\InvoiceTransformer;
use App\Plane2Ninja\Transformers\PaymentTransformer;
use App\Plane2Ninja\Transformers\ProductTransformer;
use Illuminate\Support\Collection;

class NinjaFactory
{

    /**
     * NinjaFactory constructor.
     */


    protected $clientTransformer;

    protected $invoiceTransformer;

    protected $paymentTransformer;

    protected $invoiceItemTransformer;

    protected $productTransformer;

    public function __construct(ClientTransformer $clientTransformer, InvoiceTransformer $invoiceTransformer, PaymentTransformer $paymentTransformer, InvoiceItemTransformer $invoiceItemTransformer, ProductTransformer $productTransformer)
    {
        $this->clientTransformer = $clientTransformer;
        $this->invoiceTransformer = $invoiceTransformer;
        $this->paymentTransformer = $paymentTransformer;
        $this->invoiceItemTransformer = $invoiceItemTransformer;
        $this->productTransformer = $productTransformer;
    }

    public function buildNinja(Collection $clients)
    {
        $ninjaArray = [];
        $x = 0;

        foreach($clients as $client) {

            $ninjaArray[] = $this->clientTransformer->transform($client);
            $ninjaArray[]['invoices'] = $this->buildInvoices($client->invoices()->get());

            $x++;
        }

        return $ninjaArray;
    }

    public function buildProducts($products) {

        $productObjects = [];

        foreach($products as $product)
            $productObjects[] = $this->productTransformer->transform($product);

        return $productObjects;
    }

    private function buildInvoices($invoices)
    {
        $invoiceObjects = [];
        $x = 0;

        foreach($invoices as $invoice)
        {
        $invoiceObjects[$x] = $this->invoiceTransformer->transform($invoice);

            $i = 0;
            foreach($invoice->items()->get() as $item) {
                $invoiceObjects[$x]['invoice_items'][$i] = $this->invoiceItemTransformer->transform($item);
                $i++;
            }

            $j = 0;
            foreach($invoice->payments()->get() as $payment) {
                $invoiceObjects[$x]['payments'][$j] = $this->paymentTransformer->transform($payment);
                $j++;
            }

            $x++;
        }

        return $invoiceObjects;
    }


}