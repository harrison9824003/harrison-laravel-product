<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\Category;
use Illuminate\Support\Collection;

class CategoryService
{
    public function __construct(
        private Category $category
    ) {
    }

    public function getByParentId(int $parentId = 0): Collection
    {
        return $this->category->where('parent_id', $parentId)->get();
    }

    /**
     * 取得全站類別 model id
     */
    public function getModelId(): int
    {
        return $this->category->getModelId();
    }
}
