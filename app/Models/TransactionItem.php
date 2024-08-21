<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'transaction_items';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'qty',
        'sub_total',
    ];
    public $primaryKey = 'uuid';
    public $incrementing = false;
    public $keyType = 'string';

    public function transaction()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
