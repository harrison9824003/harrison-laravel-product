<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\SpecCategory;
use Harrison\LaravelProduct\Models\ValueObjects\Product\PageCondition;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SpecCategoryService
{
    public function __construct(
        private SpecCategory $specCategory
    ) {
    }

    public function getByParentId(int $parentId = 0): Collection
    {
        return $this->specCategory->where('parent_id', $parentId)->get();
    }

    public function getChildenSpec(int $parentId): Collection
    {
        return $this->specCategory
            ->select(['id', 'name', 'parent_id'])
            ->where('parent_id', $parentId)
            ->get();
    }

    public function getByPage(PageCondition $condition): LengthAwarePaginator
    {
        return $this->specCategory->paginate(
            $prePage = $condition->getValue('limit'),
            $columns = ['*']
        );
    }

    public function create(array $input): SpecCategory
    {
        return $this->specCategory->create($input);
    }

    public function find(int $id): SpecCategory
    {
        return $this->specCategory->findOrFail($id);
    }

    /**
     * 取得商品規格 model id
     */
    public function getModelId(): int
    {
        return $this->specCategory->getModelId();
    }
}
