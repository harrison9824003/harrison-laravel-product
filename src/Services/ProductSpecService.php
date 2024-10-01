<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\ProductSpec;
use Illuminate\Support\Collection;

/**
 * 商品規格服務
 */
class ProductSpecService
{
    public function __construct(
        private ProductSpec $productSpec
    ) {}

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
     * 下架特定規格的商品,將 status 設為 0
     */
    public function deleteProductSpecBySpecId(int $specId): void
    {
        $this->productSpec->where('spec_id', $specId)->update(['status' => 0]);
    }

    public function getProductSpec(int $productId): Collection
    {
        return $this->productSpec->where('product_id', $productId)->get();
    }
}
