<?php

namespace App\Plane2Ninja\Transformers;

use App\Models\Product;

class ProductTransformer extends BaseTransformer
{

    public function transform(Product $product)
    {
        return [
            'id' => $product->product_id,
            'product_key' => $this->getString($product->product_name),
            'notes' => $this->getString($product->product_description),
            'cost' => $this->getFloat($product->product_price),
            'tax_name1' => $this->getTaxName($product),
            'tax_rate1' => $this->getTaxRate($product),
        ];
    }

    private function getTaxRate(Product $item) {

        if(isset($item->tax_rate()->tax_rate_percent))
            return $item->tax_rate()->tax_rate_percent;
        else
            return 0;

    }

    private function getTaxName(Product $item){


        if(isset( $item->tax_rate()->tax_rate_name) )
            return $item->tax_rate()->tax_rate_name;
        else
            return '';

    }
}