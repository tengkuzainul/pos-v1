<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'invoices';
    protected $fillable = ['invoice_no', 'transaction_id'];
    public $primaryKey = 'uuid';
    public $incrementing = false;
    public $keyType = 'string';

    public function transactions()
    {
        return $this->belongsTo(Transaction::class, 'transaction_id');
    }
}
