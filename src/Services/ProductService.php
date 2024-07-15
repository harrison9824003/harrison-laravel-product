<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\Product;
use Harrison\LaravelProduct\Models\ValueObjects\Product\PageCondition;
use Illuminate\Pagination\LengthAwarePaginator;

class ProductService
{
    public function __construct(
        private Product $product
    ) {
    }

    /**
     * 商品列表
     */
    public function getByPage(PageCondition $condition): LengthAwarePaginator
    {
        try {
            // $this->product->with('specs')->paginate(
            //     $prePage = $condition->getValue('limit'),
            //     $columns = ['*']
            // );
            $this->product->get();
        } catch (\Exception $e) {
            dd($e->getMessage());
        }
        return $this->product->with('specs')->paginate(
            $prePage = $condition->getValue('limit'),
            $columns = ['*']
        );
    }

    /**
     * 查詢單一商品
     */
    public function find(int $id): Product
    {
        return $this->product->findOrFail($id);
    }

    /**
     * 新增商品
     */
    public function create(array $input): Product
    {
        return $this->product->create($input);
    }

    /**
     * 更新商品
     */
    public function update(Product $updateProduct, array $input): void
    {
        $updateProduct->update($input);
    }

    /**
     * 取得商品 model id
     */
    public function getModelId(): int
    {
        return $this->product->getModelId();
    }
}
