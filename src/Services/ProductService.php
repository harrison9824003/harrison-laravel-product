<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\Product;
use Harrison\LaravelProduct\Models\ValueObjects\Common\PageCondition;
use Harrison\LaravelProduct\Services\Traits\DatabaseService;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * 商品服務
 */
class ProductService
{
    use DatabaseService;

    public function __construct() {}

    /**
     * 商品列表
     */
    public function getByPage(PageCondition $condition): LengthAwarePaginator
    {
        try {
            Product::with('specs')->paginate(
                perPage: $condition->getValue('limit'),
                columns: ['*']
            );
        } catch (\Exception $e) {
            dd($e->getMessage());
        }

        return Product::with('specs')->paginate(
            $prePage = $condition->getValue('limit'),
            $columns = ['*']
        );
    }

    /**
     * 查詢單一商品
     */
    public function find(int $id): Product
    {
        return Product::findOrFail($id);
    }

    /**
     * 新增商品
     */
    public function create(array $input): Product
    {
        return Product::create($input);
    }

    /**
     * 更新商品
     */
    public function update(Product $updateProduct, array $input): void
    {
        $updateProduct->update($input);
    }
}
