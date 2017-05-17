<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_payments';

    public function invoice()
    {
        return $this->belongsTo('App\Models\Invoice', 'invoice_id', 'invoice_id');
    }

}