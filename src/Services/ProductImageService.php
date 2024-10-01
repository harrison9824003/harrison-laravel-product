<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\ProductImage;
use Illuminate\Support\Collection;

class ProductImageService
{
    public function __construct(
        private ProductImage $productImage
    ) {}

    public function create(array $input): ProductImage
    {
        return $this->productImage->create($input);
    }

    public function getProductImage(int $id): Collection
    {
        return $this->productImage
            ->where('item_id', $id)
            ->get();
    }
}
