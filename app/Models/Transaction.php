<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transactions';
    protected $fillable = [
        'total_price',
        'payment_method',
        'payment_amount',
        'refund_payment',
    ];
    public $primaryKey = 'uuid';
    public $incrementing = false;
    public $keyType = 'string';

    public function transactionItems()
    {
        return $this->hasMany(TransactionItem::class, 'transaction_id');
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'transaction_items', 'transaction_id', 'product_id')
            ->withPivot('qty', 'sub_total')
            ->withTimestamps();
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class, 'transaction_id');
    }
}
