<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\ProductSpec;
use Illuminate\Support\Collection;

class ProductSpecService
{
    public function __construct(
        private ProductSpec $productSpec
    ) {
    }

    public function create(array $input): ProductSpec
    {
        return $this->productSpec->create($input);
    }

    public function update(ProductSpec $productSpec, array $input): void
    {
        $productSpec->update($input);
    }

    public function find(int $id): ProductSpec
    {
        return $this->productSpec->findOrFail($id);
    }

    public function deleteProductSpec(int $productId): void
    {
        $this->productSpec->where('product_id', $productId)->delete();
    }

    /**
     * 取得商品規格 model id
     */
    public function getModelId(): int
    {
        return $this->productSpec->getModelId();
    }

    public function getProductSpec(int $productId): Collection
    {
        return $this->productSpec->where('product_id', $productId)->get();
    }
}
