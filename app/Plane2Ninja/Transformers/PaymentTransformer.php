<?php

namespace App\Plane2Ninja\Transformers;

use App\Models\Payment;

class PaymentTransformer extends BaseTransformer
{

    public function transform(Payment $payment)
    {
        return [
            'id'=> $payment->payment_id,
            'amount' => $this->getFloat($payment->payment_amount),
            'payment_date' => $this->getDate($payment->payment_date),
            'client_id' => $payment->invoice()->first()->client_id,
            'invoice_id' => $payment->invoice_id,
            'payment_type_id' => 3,
        ];
    }


}