<?php

namespace App\Plane2Ninja\Transformers;

use App\Models\Invoice;
use App\Models\TaxRate;

/**
 * Class InvoiceTransformer
 * @package App\Plane2Ninja\Transformers
 */
class InvoiceTransformer extends BaseTransformer
{

    /**
     * @param Invoice $invoice
     * @return array
     */
    public function transform(Invoice $invoice)
    {
        return [
            'client_id' => $invoice->client_id,
            'invoice_number' => $invoice->invoice_number ? $this->getInvoiceNumber($invoice->invoice_number) : null,
            'amount' => $invoice->amount()->get()->first()->invoice_total,
            'po_number' => '',
            'terms' => $this->getString($invoice->invoice_terms),
            'public_notes' => '',
            'invoice_date' => $this->getDate($invoice->invoice_date_created),
            'due_date' => $this->getDate($invoice->invoice_due_date),
            'invoice_status_id' => $this->transformInvoiceStatus($invoice->invoice_status_id),
            'is_amount_discount' => $this->checkDiscountAmount($invoice),
            'discount' => $this->fillDiscount($invoice),
            'tax_name1' => $this->getTaxName($invoice,1),
            'tax_rate1' => $this->getTaxRate($invoice,1),
            'tax_name2' => $this->getTaxName($invoice,2),
            'tax_rate2' => $this->getTaxRate($invoice,2),
            'invoice_design_id' =>1,
            'is_public'=>1,
        ];
    }


    private function getTaxRate($invoice, $index) {

        $taxRate = $invoice->tax_rates()->get()->toArray();

        if(isset($taxRate[$index-1]['tax_rate_id'])) {
            $tax_rate = TaxRate::where(['tax_rate_id'=>$taxRate[$index-1]['tax_rate_id']])->first();
            return $tax_rate->tax_rate_percent;
        }
        else
            return 0;

    }

    private function getTaxName($invoice, $index){

        $taxName = $invoice->tax_rates()->get()->toArray();

        if(isset($taxName[$index-1]['tax_rate_id'])) {
            $tax_rate = TaxRate::where(['tax_rate_id'=>$taxName[$index-1]['tax_rate_id']])->first();
            return $tax_rate->tax_rate_name;
        }
        else
            return '';

    }

    /**
     * @param Invoice $invoice
     * @return bool|null
     */
    private function checkDiscountAmount(Invoice $invoice){

        if($invoice->invoice_discount_amount > 0)
            return true;
        elseif($invoice->invoice_discount_percent > 0)
            return false;
        else
            return null;

    }

    /**
     * @param Invoice $invoice
     * @return int|mixed
     */
    private function fillDiscount(Invoice $invoice){

        if($invoice->invoice_discount_amount > 0)
            return $invoice->invoice_discount_amount;
        elseif($invoice->invoice_discount_percent > 0)
            return $invoice->invoice_discount_percent;
        else
            return 0;

    }

    /**
     * @param $invoiceStatus
     * @return int
     */
    private function transformInvoiceStatus($invoiceStatus) {


        switch($invoiceStatus)
        {
            case 1:
                return 1;
            case 2:
                return 2;
            case 3:
                return 3;
            case 4:
                return 6;
            default:
                return 1;
        }
    }

}