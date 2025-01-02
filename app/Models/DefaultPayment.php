<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DefaultPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'default_payment_next_month',
        'statement_id'
    ];

    protected $casts = [
        'default_payment_next_month' => 'boolean'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
    public function statement()
    {
        return $this->belongsTo(CreditCardStatement::class);
    }
}
