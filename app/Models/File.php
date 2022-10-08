<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = ['name','url','small_name','medium_name','large_name','original_name','alt'];

    public function products()
    {
        return $this->belongsToMany(product::class);
    }
}
