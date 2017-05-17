<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_quotes';

    public function items()
    {
        return $this->hasMany('App\Models\QuoteItem', 'quote_id', 'quote_id');
    }

    public function amount()
    {
        return $this->hasOne('App\Models\QuoteAmount','quote_id', 'quote_id');
    }

    public function tax_rates()
    {
        return $this->hasMany('App\Models\QuoteTaxRate','quote_id','quote_id');
    }

}