<?php

namespace App\Plane2Ninja\Transformers;

use App\Models\InvoiceItem;

class InvoiceItemTransformer extends BaseTransformer
{

    public function transform(InvoiceItem $item)
    {
        return
            [
                'product_key' => $item->item_name,
                'notes' => $item->item_description,
                'cost' => $item->item_price,
                'qty' => $item->item_quantity ?: 1,
                'tax_name1' => $this->getTaxName($item),
                'tax_rate1' => $this->getTaxRate($item),
            ];
    }

    private function getTaxRate($item) {

        $taxRate = $item->tax_rate();

        if(isset($taxRate))
            return $taxRate->tax_rate_percent;
        else
            return 0;

    }

    private function getTaxName($item){

        $taxName = $item->tax_rate();

        if(isset($taxName))
            return $taxName->tax_rate_name;
        else
            return null;

    }
}