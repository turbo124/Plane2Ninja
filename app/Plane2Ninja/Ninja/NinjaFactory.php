<?php

namespace App\Plane2Ninja\Ninja;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\QuoteItem;
use App\Plane2Ninja\Transformers\ClientTransformer;
use App\Plane2Ninja\Transformers\InvoiceItemTransformer;
use App\Plane2Ninja\Transformers\InvoiceTransformer;
use App\Plane2Ninja\Transformers\PaymentTransformer;
use App\Plane2Ninja\Transformers\ProductTransformer;
use App\Plane2Ninja\Transformers\QuoteItemTransformer;
use App\Plane2Ninja\Transformers\QuoteTransformer;
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

    protected $quoteTransformer;

    protected $quoteItemTransformer;

    public function __construct(ClientTransformer $clientTransformer, InvoiceTransformer $invoiceTransformer, PaymentTransformer $paymentTransformer, InvoiceItemTransformer $invoiceItemTransformer, ProductTransformer $productTransformer, QuoteTransformer $quoteTransformer, QuoteItemTransformer $quoteItemTransformer)
    {
        $this->clientTransformer = $clientTransformer;
        $this->invoiceTransformer = $invoiceTransformer;
        $this->paymentTransformer = $paymentTransformer;
        $this->invoiceItemTransformer = $invoiceItemTransformer;
        $this->productTransformer = $productTransformer;
        $this->quoteTransformer = $quoteTransformer;
        $this->quoteItemTransformer = $quoteItemTransformer;
    }

    public function buildNinja(Collection $clients)
    {
        $ninjaArray = [];
        $x = 0;

        foreach($clients as $client) {

            $ninjaArray[] = $this->clientTransformer->transform($client);
            //$ninjaArray[]['invoices'] = $this->buildInvoices($client->invoices()->get());

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

    public function buildInvoices($invoices)
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

            if(count($invoice->items()->get()) == 0) {

                $item = new InvoiceItem();
                $item->item_quantity = 1;
                $item->item_price = $invoice->amount()->get()->first()->invoice_total;
                $item->item_description = "Generic Line Item";
                $item->item_name = "Generic Key";

                $invoiceObjects[$x]['invoice_items'][0] = $this->invoiceItemTransformer->transform($item);
            }

            $j = 0;
            foreach($invoice->payments()->get() as $payment) {
                $invoiceObjects[$x]['payments'][$j] = $this->paymentTransformer->transform($payment);
                $j++;
            }

            if(count($invoice->payments()->get()) == 0)
                $invoiceObjects[$x]['payments'][0] = [];

            $x++;
        }

        return $invoiceObjects;
    }

    public function buildQuotes($quotes)
    {
        $quoteObjects = [];
        $x = 0;

        foreach ($quotes as $quote)
        {
        $quoteObjects[$x] = $this->quoteTransformer->transform($quote);

            $i = 0;
            foreach($quote->items()->get() as $item) {
                $quoteObjects[$x]['invoice_items'][$i] = $this->quoteItemTransformer->transform($item);
                $i++;
            }

            if(count($quote->items()->get()) == 0) {

                $item = new QuoteItem();
                $item->item_quantity = 1;
                $item->item_price = $quote->amount()->get()->first()->invoice_total;
                $item->item_description = "Generic Line Item";
                $item->item_name = "Generic Key";

                $quoteObjects[$x]['invoice_items'][0] = $this->quoteItemTransformer->transform($item);
            }

                $quoteObjects[$x]['payments'] = [];

            $x++;

        }

        return $quoteObjects;
    }


}