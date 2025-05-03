<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'buyer_name',
        'total_price',
        'amount_paid',
        'payment_method',
        'change',
        'status'
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }
}
