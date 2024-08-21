<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'products';
    protected $fillable = [
        'name',
        'price',
        'stock',
        'description',
        'available',
        'image_thumbnail',
        'category_id',
    ];
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public $keyType = 'string';

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function transactions()
    {
        return $this->belongsToMany(Transaction::class, 'transaction_items', 'product_id', 'transaction_id')
            ->withPivot('qty', 'sub_total')
            ->withTimestamps();
    }
}
