<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'sex',
        'education_id',
        'marriage_id',
        'age',
        'limit_bal'
    ];

    public function education()
    {
        return $this->belongsTo(Education::class);
    }

    public function marriage()
    {
        return $this->belongsTo(Marriage::class);
    }

    public function creditCardStatements()
    {
        return $this->hasMany(CreditCardStatement::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function defaultPayment()
    {
        return $this->hasOne(DefaultPayment::class);
    }
}
