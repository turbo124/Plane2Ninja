<?php

namespace App\Plane2Ninja\Transformers;

use App\Models\InvoiceItem;

class InvoiceItemTransformer extends BaseTransformer
{

    /*
     *
     * Line item discounts now implemented
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
                'discount' => $item->item_discount_amount ? $item->item_discount_amount : 0,
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