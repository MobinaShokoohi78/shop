<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'color_id', 'size_id', 'count', 'price'];

    public function products()
    {
        return $this->belongsTo(product::class);
    }
}
