<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CreditCardStatement extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'bill_amt',
        'bill_date',
        'pay_amt'
    ];

    protected $casts = [
        'bill_date' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function payments()
    {
        return $this->hasOne(Payment::class, 'statement_id');
    }
    public function predict()
    {
        return $this->hasOne(DefaultPayment::class, 'statement_id');
    }
}
