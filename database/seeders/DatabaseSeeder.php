<?php

namespace Database\Seeders;

use App\Models\Attribute;
use App\Models\AttributeValue;
use App\Models\Category;
use App\Models\Comment;
use App\Models\File;
use App\Models\Product;
use App\Models\ProductDetail;
use App\Models\User;
use Database\Factories\CategoryFactory;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
//         \App\Models\User::factory(50)->create();

//        Attribute::factory(20)->create();

//        AttributeValue::factory(50)->create();

//        Category::factory(50)->create();

//        Product::factory(20)->create();

//        ProductDetail::factory(100)->create();

//        File::factory(50)->create();



//        Product::factory()
//            ->hasAttached(
//                Attribute::factory()->count(20),
//                ['value_id' => AttributeValue::all()->random()->id]
//            )
//            ->create();


//        product::factory()
//            ->has(File::factory()->count(50),)->create();

        Comment::factory(20)->create();
    }
}
