<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItemAmount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_invoice_item_amounts';

    public function tax_rate()
    {
        return $this->hasOne('App\Models\TaxRate', 'item_tax_rate_id', 'tax_rate_id');
    }

    
}