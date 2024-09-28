<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\SpecCategory;
use Harrison\LaravelProduct\Models\ValueObjects\Product\PageCondition;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class SpecCategoryService
{
    public function __construct() {}

    public function getByParentId(int $parentId = 0): Collection
    {
        return SpecCategory::where('parent_id', $parentId)->get();
    }

    public function getChildenSpec(int $parentId): Collection
    {
        return SpecCategory::select(
                ['id', 'name', 'parent_id']
            )
            ->where('parent_id', $parentId)
            ->get();
    }

    public function getByPage(PageCondition $condition): LengthAwarePaginator
    {
        return SpecCategory::paginate(
            $prePage = $condition->getValue('limit'),
            $columns = ['*']
        );
    }

    public function create(string $name, int $parentId): SpecCategory
    {
        return SpecCategory::create([
            'name' => $name,
            'parent_id' => $parentId
        ]);
    }

    public function find(int $id): SpecCategory
    {
        return SpecCategory::findOrFail($id);
    }
}
