<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeProduct extends Model
{
    use HasFactory;
    protected $fillable = ['product_id', 'attribute_id', 'value_id'];

    public function Products()
    {
        return $this->belongsToMany(Product::class);
    }
    public function Attributes()
    {
        return $this->belongsToMany(Attribute::class);
    }
}
