<?php

namespace App\Plane2Ninja\Transformers;

use App\Models\InvoiceItem;

class InvoiceItemTransformer extends BaseTransformer
{

    /*
     *
     * Invoice plane has the ability to implement discounts on line items,
     * this is an issue as this data cannot be translated across to Invoice Ninja
     *
     * The solution is to carry over the line item discounts into the invoice discount field.
     * This will need to be calculated.
     *
     *
    */

    public function transform(InvoiceItem $item)
    {
        return
            [
                'product_key' => $item->item_name,
                'notes' => $item->item_description,
                'cost' => $item->item_price,
                'qty' => $item->item_quantity ? $item->item_quantity : 1,
                'tax_name1' => $this->getTaxName($item),
                'tax_rate1' => $this->getTaxRate($item),
                'invoice_item_type_id' => 1,
            ];
    }

    private function getTaxRate($item) {

        $taxRate = $item->tax_rate()->get();

        if(isset($taxRate->tax_rate_percent))
            return $taxRate->tax_rate_percent;
        else
            return 0;

    }

    private function getTaxName($item){

        $taxName = $item->tax_rate()->get();

        if(isset($taxName->tax_rate_name))
            return $taxName->tax_rate_name;
        else
            return '';

    }
}