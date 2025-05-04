<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TransactionItem extends Model
{
    use SoftDeletes;
    protected $fillable = ['transaction_id', 'product_id', 'quantity', 'price'];

    public function product()
    {
        return $this->belongsTo(Product::class)->withTrashed();
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    
}
