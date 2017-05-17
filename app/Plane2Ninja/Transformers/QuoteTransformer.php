<?php

namespace App\Plane2Ninja\Transformers;

use App\Models\Quote;

/**
 * Class InvoiceTransformer
 * @package App\Plane2Ninja\Transformers
 */
class QuoteTransformer extends BaseTransformer
{

    /**
     * @param Invoice $invoice
     * @return array
     */
    public function transform(Quote $quote)
    {
        return [
            'client_id' => $quote->client_id,
            'invoice_number' => $quote->quote_number ? $this->getInvoiceNumber($quote->quote_number) : null,
            'po_number' => '',
            'terms' => '',
            'public_notes' => '',
            'invoice_date' => $this->getDate($quote->quote_date_created),
            'due_date' => $this->getDate($quote->invoice_due_date),
            'invoice_status_id' => $this->transformQuoteStatus($quote->quote_status_id),
            'is_amount_discount' => $this->checkDiscountAmount($quote),
            'discount' => $this->fillDiscount($quote),
            'tax_name1' => $this->getTaxName($quote,1),
            'tax_rate1' => $this->getTaxRate($quote,1),
            'tax_name2' => $this->getTaxName($quote,2),
            'tax_rate2' => $this->getTaxRate($quote,2),
        ];
    }


    private function getTaxRate($quote, $index) {

        $taxRate = $quote->tax_rates()->get($index--);

        if(isset($taxRate))
            return $taxRate->tax_rate_percent;
        else
            return 0;

    }

    private function getTaxName($quote, $index){

        $taxName = $quote->tax_rates()->get($index--);

        if(isset($taxName))
            return $taxName->tax_rate_name;
        else
            return '';

    }

    /**
     * @param Invoice $invoice
     * @return bool|null
     */
    private function checkDiscountAmount(Quote $quote){

        if($quote->quote_discount_amount > 0)
            return true;
        elseif($quote->quote_discount_percent > 0)
            return false;
        else
            return null;

    }

    /**
     * @param Invoice $invoice
     * @return int|mixed
     */
    private function fillDiscount(Quote $quote){

        if($quote->quote_discount_amount > 0)
            return $quote->quote_discount_amount;
        elseif($quote->quote_discount_percent > 0)
            return $quote->quote_discount_percent;
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

    private function transformQuoteStatus($quoteStatus) {

        switch($quoteStatus)
        {
            case 1:
                return 1;
            case 2:
                return 2;
            case 3:
                return 3;
            case 4:
                return 4;
            case 5:
                return 5;
            case 6:
                return 6;
            default:
                return 1;
        }
    }

}