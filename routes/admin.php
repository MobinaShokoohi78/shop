<?php

use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\Admin\ColorsController;
use App\Http\Controllers\Admin\CommentsController;
use App\Http\Controllers\Admin\ProductsController;
use App\Http\Controllers\Admin\SizesController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\Admin\UserController;

Route::get('/',function (){
     return Inertia::render('Admin/Index');
});

Route::resource('users',UserController::class);
Route::post('users/data',[UserController::class,'getData'])->name('users.data');

Route::resource('attributes',AttributeController::class);
Route::post('attributes/data',[AttributeController::class,'getData'])->name('attributes.data');

Route::resource('categories',CategoriesController::class);
Route::post('categories/data',[CategoriesController::class,'getData'])->name('categories.data');

Route::resource('comments',CommentsController::class);
Route::post('comments/data',[CommentsController::class,'getData'])->name('comments.data');

Route::resource('colors',ColorsController::class);
Route::post('colors/data',[ColorsController::class,'getData'])->name('colors.data');

Route::resource('sizes',SizesController::class);
Route::post('sizes/data',[SizesController::class,'getData'])->name('sizes.data');

Route::resource('products',ProductsController::class);
Route::post('products/data',[ProductsController::class,'getData'])->name('products.data');
Route::post('products/details/update/{id}',[ProductsController::class,'updateDetails'])->name('products.details.update');
Route::post('products/attributes/values/{id}',[ProductsController::class,'getValues'])->name('products.attributes.values.get');
Route::post('products/attributes/values/update/{id}',[ProductsController::class,'updateAttr'])->name('products.attributes.values.update');
