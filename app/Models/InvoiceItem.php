<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_invoice_items';

    public function amount()
    {
        return $this->hasOne('App\Models\InvoiceItemAmount','item_id', 'item_id');
    }

    public function tax_rate()
    {
        return $this->hasOne('App\Models\TaxRate','tax_rate_id', 'item_tax_rate_id');
    }
}