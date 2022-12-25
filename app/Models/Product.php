<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description','category_id'];

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function producctDetails()
    {
        return $this->hasMany(ProductDetail::class);
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class)->withPivot('value');
    }

    public function files()
    {
        return $this->belongsToMany(File::class);
    }

    public function oldestFile()
    {
        return $this->hasOne(File::class)->oldestOfMany();
    }

    public function categories()
    {
        return $this->hasOne(Category::class);
    }

    public function attributeProduct()
    {
        return $this->hasMany(AttributeProduct::class);
    }
}
