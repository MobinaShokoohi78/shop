<?php

use App\Http\Controllers\admin\AttributeController;
use App\Http\Controllers\Admin\CategoriesController;
use App\Http\Controllers\admin\CommentsController;
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
