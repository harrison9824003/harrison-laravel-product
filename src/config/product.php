<?php

use Harrison\LaravelProduct\Models\Category;
use Harrison\LaravelProduct\Models\Product;
use Harrison\LaravelProduct\Models\ProductImage;
use Harrison\LaravelProduct\Models\SpecCategory;

return [
    'product' => [
        'id' => 2,
        'route' => 'product',
        'icon' => 'bxl-product-hunt',
        'name' => '商品',
        'class' => Product::class
    ],
    'specCategory' => [
        'id' => 3,
        'route' => 'spec',
        'icon' => 'bx-category',
        'name' => '規格分類',
        'class' =>  SpecCategory::class
    ],
    'category' => [
        'id' => 5,
        'route' => 'category',
        'icon' => 'bx-category',
        'name' => '全站分類',
        'class' => Category::class
    ],
    'productImage' => [
        'id' => 7,
        'route' => 'productimg',
        'icon' => 'bx-image-alt',
        'name' => '商品圖片',
        'class' => ProductImage::class
    ]
];