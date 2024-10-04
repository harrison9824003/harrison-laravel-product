<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\ProductImage;
use Illuminate\Support\Collection;

class ProductImageService
{
    public function __construct(
    ) {}

    public function create(array $input): ProductImage
    {
        return ProductImage::create($input);
    }

    public function getProductImage(int $id): Collection
    {
        return ProductImage::where('item_id', $id)
            ->get();
    }
}
