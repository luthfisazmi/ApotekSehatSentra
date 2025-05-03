<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'admin_id',
        'buyer_name', 
        'email', 
        'address', 
        'quantity',
        'total_price',
        'amount_paid', 
        'payment_method', 
        'sub_payment',  
        'change', 
        
    ];

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('quantity');
    }

    public function transactionItems()
{
    return $this->hasMany(TransactionItem::class);
}

public function admin() {
    return $this->belongsTo(Admin::class);
}

}
