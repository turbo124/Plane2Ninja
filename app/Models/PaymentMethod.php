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
    protected $table = 'ip_payment_methods';


    public function payment()
    {
        return $this->belongsTo('App\Models\Payment', 'payment_method_id', 'payment_method_id');
    }

    
}