<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\ProductImage;
use Illuminate\Support\Collection;

class ProductImageService
{
    public function __construct(
        private ProductImage $productImage
    ) {
    }

    public function create(array $input): ProductImage
    {
        return $this->productImage->create($input);
    }

    /**
     * 取得商品圖片 model id
     */
    public function getModelId(): int
    {
        return $this->productImage->getModelId();
    }

    public function getProductImage(int $id): Collection
    {
        return $this->productImage
            ->where('item_id', $id)
            ->where('data_id', $this->getModelId())
            ->get();
    }
}
