<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteAmount extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_quote_amounts';

    public function amount()
    {
        return $this->hasOne('App\Models\QuoteItemAmount','item_id', 'item_id');
    }

    public function tax_rate()
    {
        return $this->hasOne('App\Models\TaxRate','tax_rate_id', 'item_tax_rate_id');
    }
}