<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InvoiceTaxRate extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_invoice_tax_rates';

    public function tax_rate() {
        return $this->hasMany('App\Models\TaxRate', 'tax_rate_id', 'tax_rate_id');
    }
}