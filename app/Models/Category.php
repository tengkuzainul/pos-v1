<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'categories';
    protected $fillable = ['name'];
    protected $primaryKey = 'uuid';
    public $incrementing = false;
    public $keyType = 'string';

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}
