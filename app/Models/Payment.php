<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'statement_id',
        'payment_date',
        'amount_paid',
        'payment_status'
    ];

    protected $casts = [
        'payment_date' => 'date'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function statement()
    {
        return $this->belongsTo(CreditCardStatement::class, 'statement_id');
    }
}
