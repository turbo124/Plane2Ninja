<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_products';

    public function tax_rate()
    {
        return $this->hasOne('App\Models\TaxRate', 'tax_rate_id', 'tax_rate_id');
    }
}