<?php
use Illuminate\Support\Facades\Route;

use Harrison\LaravelProduct\Controllers\ProductController;
use Harrison\LaravelProduct\Controllers\SpecCategoryController;

// 商品管理
Route::resource('product', ProductController::class);
// 規格管理
Route::resource('spec', SpecCategoryController::class);
Route::post('/getChildenSpec/{spec}', [ProductController::class, 'getChildenSpec'])->name('getChildenSpec');
?>