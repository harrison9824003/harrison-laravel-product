<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\SpecCategory;
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

    /**
     * 取得商品規格 model id
     */
    public function getModelId(): int
    {
        return $this->specCategory->getModelId();
    }
}
