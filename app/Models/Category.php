<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name','parent'];


    public function child(){
        return $this->hasMany(Category::class,'parent', 'id')->with('child');
    }


    public function products()
    {
        return $this->belongsTo(product::class);
    }

    public $categoriesList = [];
    public function scopeCategoriesList($query){
        $categories = Category::select('id','name','parent')->where('parent', 0)->get()->toArray();
        return self::makeCategoriesList($categories);
    }

    function makeCategoriesList($categories,$data=[])
    {
        foreach ($categories as $category){
            array_push($data,$category['name']);
            if($childs = Category::select('id','name','parent')->where('parent', $category['id'])->get()->toArray()){
                $this->makeCategoriesList($childs,$data);
            }
            array_push($this->categoriesList,['id' => $category['id'], 'text' => implode('، ',$data)]);
            array_pop($data);
        }

        return $this->categoriesList;

    }
}
