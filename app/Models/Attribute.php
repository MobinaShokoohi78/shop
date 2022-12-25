<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function Products()
    {
        return $this->belongsToMany(product::class);
    }

    public function AttributeValues()
    {
        return $this->hasMany(AttributeValue::class);
    }

    public function AttributeProducts()
    {
        return $this->hasMany(AttributeProduct::class);
    }
}
