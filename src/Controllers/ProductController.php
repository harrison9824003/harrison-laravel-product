<?php

namespace Harrison\LaravelProduct\Controllers;

use App\Http\Controllers\Controller;
use Harrison\LaravelProduct\Events\DeleteProduct;
use Harrison\LaravelProduct\Requests\ProductRequest;
use Harrison\LaravelProduct\Mails\ProductCreate;
use Harrison\LaravelProduct\Mails\ProductUpdate;
use Harrison\LaravelProduct\Models\RelationShipCatory;
use Harrison\LaravelProduct\Models\ProductImage;
use Harrison\LaravelProduct\Models\ProductSpec;
use Harrison\LaravelProduct\Models\Product;
use Exception;
use Harrison\LaravelProduct\Models\ValueObjects\Product\PageCondition;
use Harrison\LaravelProduct\Requests\ProductPageRequest;
use Harrison\LaravelProduct\Responses\ApiResponse;
use Harrison\LaravelProduct\Services\CategoryService;
use Harrison\LaravelProduct\Services\ProductImageService;
use Harrison\LaravelProduct\Services\ProductService;
use Harrison\LaravelProduct\Services\ProductSpecService;
use Harrison\LaravelProduct\Services\SpecCategoryService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Redis\RedisManager;

class ProductController extends Controller
{
    public function __construct(
        private ProductService $productService,
        private CategoryService $categoryService,
        private SpecCategoryService $specCategoryService,
        private ProductImageService $productImageService,
        private ProductSpecService $productSpecService
    ) {
    }

    /**
     * 商品列表
     */
    public function index(ProductPageRequest $request): ApiResponse
    {
        $pageCondition = new PageCondition(
            $request->get('currentPage', 1),
            $request->get('perPage', 10)
        );
        $products = $this->productService->getByPage($pageCondition);
        return new ApiResponse($products->items(), [
            "perPage" => $products->perPage(),
            "currentPage" => $products->currentPage(),
            "total" => $products->total(),
            "lastPage" => $products->lastPage()
        ]);
    }

    /**
     * 建立商品時需要的內容
     */
    public function create(): ApiResponse
    {
        // 全站分類
        $category = $this->categoryService->getByParentId(0);

        // 規格
        $specCategory = $this->specCategoryService->getByParentId(0);

        return new ApiResponse([
            'category' => $category,
            'specCategory' => $specCategory
        ]);
    }

    /**
     * 儲存商品資料
     */
    public function store(ProductRequest $request)
    {
        $input = $request->all();
        // todo 全站圖片套件
        $files = $request->file('productImg');

        // 商品基本資料
        $productInput = $request->only([
            'name',
            'price',
            'market_price',
            'simple_intro',
            'intro',
            'part_number',
            // 'start_date'
        ]);

        if (!isset($productInput['market_price']) || empty($productInput['market_price'])) {
            $productInput['market_price'] = 0;
        }

        if (!isset($productInput['simple_intro']) || empty($productInput['simple_intro'])) {
            $productInput['simple_intro'] = '';
        }

        if (!isset($productInput['simple_intro']) || empty($productInput['simple_intro'])) {
            $productInput['part_number'] = '';
        }

        // $productInput['end_date'] = '2035-12-31';
        // $productInput['user_id'] = auth()->id();

        DB::beginTransaction();
        try {
            $product = $this->productService->create($productInput);

            // 商品圖片
            if (is_array($files) && count($files) > 0) {
                foreach ($files as $file) {
                    $path = $file->storeAs('images', md5(time()) . "." . $file->extension(), 'uploads');

                    $imgInput = [
                        'data_id' => $this->productService->getModelId(),
                        'item_id' => $product->id,
                        'path' => $path,
                        'data_type' => $file->getClientMimeType(),
                        'description' => $file->getClientOriginalName()
                    ];
                    $this->productImageService->create($imgInput);
                }
            }

            // 規格
            foreach ($input['spec_childen'] as $k => $specChilden) {
                $specInput = [
                    'category_id' => $input["spec_childen"][$k],
                    'product_id' => $product->id,
                    'reserve_num' => $input["spec_reserve"][$k],
                    'low_reserve_num' => $input["spec_low_reserve"][$k],
                    'volume' => $input["spec_volume"][$k],
                    'weight' => $input["spec_weight"][$k],
                    'order' => $input["spec_order"][$k]
                ];

                $this->productSpecService->create($specInput);
            }

            // 全站分類
            // todo 改寫 event
            // $category_input = [
            //     'data_id' => $this->productService->getModelId(),
            //     'category_id' => $input['category_childen'],
            //     'item_id' => $product->id
            // ];

            // RelationShipCatory::create($category_input);

            DB::commit();

            // cache()->set('product_' . $product->id, $product->toJson());

        } catch (Exception $e) {
            $errors = ['database_error' => $e->getMessage()];
            DB::rollBack();
        }
        // todo 改寫 event
        // Mail::to(auth()->user())->send(new ProductCreate($product));

        if (!empty($errors)) {
            return new ApiResponse($errors, null, 400);
        }

        return new ApiResponse(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * 取修改頁內容
     */
    public function edit($id)
    {
        // $this->authorize('update-product', $productObj);

        return new ApiResponse([
            'product' => $this->productService->find($id),
            'p_images' => $this->productImageService->getProductImage($id),
            'p_specs' => $this->productSpecService->getProductSpec($id),
            // 'r_category' => $rCategory->where('item_id', $id)->where('data_id', $product->getModelId())->first(),
            'category_parent' => $this->categoryService->getByParentId(0),
            'spec_parent' => $this->specCategoryService->getByParentId(0)
        ]);
    }

    /**
     * 更新商品資料
     */
    public function update(ProductRequest $request, $id)
    {
        $input = $request->all();
        $files = $request->file('productImg');

        // 商品基本資料
        $input = $request->safe()->only([
            'name',
            'price',
            'market_price',
            'simple_intro',
            'intro',
            'part_number',
            // 'start_date'
        ]);


        if (!isset($input['market_price']) || empty($input['market_price'])) {
            $input['market_price'] = 0;
        }

        if (!isset($input['simple_intro']) || empty($input['simple_intro'])) {
            $input['simple_intro'] = '';
        }

        if (!isset($input['simple_intro']) || empty($input['simple_intro'])) {
            $input['part_number'] = '';
        }

        // todo mongodb 加入商品資訊，設定過期時間，讓 mongodb 自動刪除
        // $input['end_date'] = '2035-12-31';
        // $input['user_id'] = auth()->id();

        DB::beginTransaction();
        try {

            $product = $this->productService->find($id);
            $this->productService->update($product, $input);

            $productClass = app(Product::class);

            // 商品圖片
            if (is_array($files) && count($files) > 0) {
                foreach ($files as $file) {
                    $path = $file->storeAs('images', md5(time()) . "." . $file->extension(), 'uploads');

                    $this->productImageService->create([
                        'data_id' => $this->productService->getModelId(),
                        'item_id' => $product->id,
                        'path' => $path,
                        'data_type' => $file->getClientMimeType(),
                        'description' => $file->getClientOriginalName()
                    ]);
                }
            }

            // 規格
            //$pSpec = app(ProductSpec::class);
            foreach ($input['spec_childen'] as $k => $specChilden) {
                $spec_input = [
                    'category_id' => $input["spec_childen"][$k],
                    'product_id' => $product->id,
                    'reserve_num' => $input["spec_reserve"][$k],
                    'low_reserve_num' => $input["spec_low_reserve"][$k],
                    'volume' => $input["spec_volume"][$k],
                    'weight' => $input["spec_weight"][$k],
                    'order' => $input["spec_order"][$k]
                ];

                if ($input["spec_id"][$k] == '0') {
                    $this->productSpecService->create($spec_input);
                } else {
                    $spec = $this->productSpecService->find($input["spec_id"][$k]);
                    $this->productSpecService->update($spec, $spec_input);
                }
            }

            // 全站分類
            // todo event
            // $category_input = [
            //     'data_id' => $this->productService->getModelId(),
            //     'category_id' => $input['category_childen'],
            //     'item_id' => $product->id
            // ];

            // $category = app(RelationShipCatory::class);
            // $obj = $category->findOrFail($input['category_id']);
            // $obj->update($category_input);

            // cache()->set('product_' . $product->id, $product->toJson());
            // Mail::to(auth()->user())->later(60, new ProductUpdate($product));

            DB::commit();
        } catch (Exception) {
            $errors = ['database_error' => $e->getMessage()];
            DB::rollBack();
        }

        if (!empty($errors)) {
            return new ApiResponse($errors, null, 400);
        }

        return new ApiResponse(true);
    }

    public function destroy($id): ApiResponse
    {
        try {
            DB::transaction(function () use ($id) {

                $product = app(Product::class);
                $pImage = app(ProductImage::class);
                $pSpec = app(ProductSpec::class);
                $rCategory = app(RelationShipCatory::class);

                // 商品資料刪除
                $data = $this->productService->find($id);
                $data->delete();

                // 圖片資料
                $images = $this->productImageService->getProductImage($id);
                foreach ($images as $k => $image) {
                    @unlink(public_path($image->path));
                    $image->delete();
                }

                // 規格
                $this->productSpecService->deleteProductSpec($id);

                // 全站分類
                // $rCategory->where('item_id', $id)->where('data_id', $product->getModelId())->delete();

                // event(new DeleteProduct(auth()->user(), $data));
            });
        } catch (Exception $e) {
            return new ApiResponse([
                'error' => $e->getMessage(),
                'status' => 0
            ], null, 400);
        }

        return new ApiResponse(true);
    }

    public function getChildenSpec($id)
    {
        try {
            $data = $this->specCategoryService->getChildenSpec($id);
        } catch (Exception $e) {
            return new ApiResponse([
                'error' => $e->getMessage(),
                'status' => 0
            ], null, 400);
        }

        return new ApiResponse($data);
    }
}
