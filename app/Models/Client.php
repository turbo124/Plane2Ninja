<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'ip_clients';

    public function invoices() {
        return $this->hasMany('App\Models\Invoice', 'client_id', 'client_id');
    }

    public function notes() {
        return $this->hasMany('App\Models\ClientNote', 'client_id', 'client_id');
    }

    public function quotes() {
        return $this->hasMany('App\Models\Quote', 'client_id', 'client_id');
    }
}