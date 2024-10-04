<?php

namespace Harrison\LaravelProduct\Services;

use Harrison\LaravelProduct\Models\SpecCategory;
use Harrison\LaravelProduct\Models\ValueObjects\Common\PageCondition;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

/**
 * 規格分類服務
 */
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
            'parent_id' => $parentId,
        ]);
    }

    /**
     * 查詢單一商品規格
     */
    public function find(int $id): SpecCategory
    {
        return SpecCategory::findOrFail($id);
    }

    /**
     * 檢查是否有相同名稱的商品規格在同一階層
     */
    public function findByName(string $name, int $parentId): ?SpecCategory
    {
        return SpecCategory::where([
            'name' => $name,
            'parent_id' => $parentId,
        ])->first();
    }

    /**
     * 更新商品規格
     */
    public function update(int $id, string $name, int $parentId): void
    {
        SpecCategory::where('id', $id)->update([
            'name' => $name,
            'parent_id' => $parentId,
        ]);
    }
}
