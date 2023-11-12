<?php

namespace Harrison\LaravelProduct\Controllers;

use App\Http\Controllers\Controller;
use Harrison\LaravelProduct\Models\SpecCategory;
use Harrison\LaravelProduct\Models\ValueObjects\Product\PageCondition;
use Harrison\LaravelProduct\Requests\ProductSpecRequest;
use Harrison\LaravelProduct\Responses\ApiResponse;
use Harrison\LaravelProduct\Services\SpecCategoryService;

class SpecCategoryController extends Controller
{
    public function __construct(
        private SpecCategoryService $specCategoryService
    ) {
    }

    public function index()
    {
        $pageCondition = new PageCondition(1,10);
        $specs = $this->specCategoryService->getByPage($pageCondition);

        return new ApiResponse($specs->items());
    }

    public function create()
    {
        $parent_category = $this->specCategoryService->getByParentId(0);

        return new ApiResponse([
            'parent_category' => $parent_category
        ]);
    }

    public function store(ProductSpecRequest $request)
    {
        // todo request 取得 from 物件
        $input = $request->only(['name', 'parent_id']);

        if (!isset($input['parent_id']) || empty($input['parent_id'])) {
            $input['parent_id'] = 0;
        }

        $this->specCategoryService->create($input);

        return new ApiResponse(true);
    }

    public function show($id)
    {
        //
    }

    public function edit(int $id)
    {
        $parent_category = $this->specCategoryService->getByParentId();

        $current_spec = $this->specCategoryService->find($id);
        $parent_name = '';

        // todo 改成樹狀結構回傳
        if ($current_spec->parent_id != '0') {
            $parent = $parent_category->filter(function ($value, $key) use ($current_spec) {
                return ($value->id == $current_spec->parent_id);
            });
            $parent_name = $parent->first()->name;
        }

        return new ApiResponse([
            'spec_category' => $current_spec,
            'parent_category' => $parent_category,
            'parent_name' => $parent_name
        ]);
    }

    public function update(ProductSpecRequest $request, int $id)
    {
        $input = $request->only(['name', 'parent_id']);

        $spec_category = $this->specCategoryService->find($id);

        if (!isset($input['parent_id']) || empty($input['parent_id'])) {
            $input['parent_id'] = 0;
        }

        $spec_category->name = $input['name'];
        $spec_category->parent_id = $input['parent_id'];

        $spec_category->save();

        return new ApiResponse(true);
    }

    public function destroy(int $id)
    {
        $spec_category = $this->specCategoryService->find($id);
        $spec_category->delete();

        return new ApiResponse(true);
    }
}
