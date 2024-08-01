<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 商品
 * @param int id 編號
 * @param string name 商品名稱
 * @param int price 價格
 * @param int market_price 建議售價
 * @param string simple_intro 簡介
 * @param string intro 內容
 * @param string part_number 商品編號
 * @param Carbon created_at 建立時間
 * @param Carbon updated_at 更新時間
 */
class Product extends Model
{
    use HasFactory;

    protected $connection = 'mysql';

    protected $table = 'pj_product';

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $fillable = [
        'name',
        'price',
        'market_price',
        'simple_intro',
        'intro',
        'part_number',
        'created_at',
        'updated_at',
    ];

    public function images()
    {
        $model_app = app(Product::class);
        return $this->hasMany(ProductImage::class, 'item_id', 'id')
            ->where('data_id', $model_app->getModelId());
    }

    // public function category()
    // {
    //     return $this->hasOneThrough(
    //         \App\Models\Category::class,
    //         \App\Models\RelationShipCatory::class,
    //         'item_id',
    //         'id',
    //         'id',
    //         'category_id'
    //     );
    // }

    // public function relationship()
    // {
    //     $model_app = app(\App\Models\Shop\Product::class);
    //     return $this->hasOne(\App\Models\RelationShipCatory::class, ['data_id', 'item_id'], [$model_app->getModelId(), 'id']);
    // }

    public function specs()
    {
        return $this->hasMany(ProductSpec::class, 'product_id', 'id');
    }

    /**
     * 回傳前台統一格式
     *
     * category: 網站總分類
     * title: 資料標題
     * sub_title: 資料副標題
     * create: 建立時間
     * update: 建立時間
     * create_person: 建立人員
     * update_person: 修改人員
     * content: 主內容
     * simple_content: 簡介內容
     * other: 其他內容 e.g. 商品的規格、分類等, 由頁面本身判斷顯示
     */
    public function getFrontData()
    {
        return [
            'id' => $this->id,
            'category' => strip_tags($this->category->name),
            'title' => strip_tags($this->name),
            'sub_title' => null,
            'create' => date("Y-m-d", strtotime($this->created_at)),
            'update' =>  date("Y-m-d", strtotime($this->updated_at)),
            'create_person' => null,
            'update_person' => null,
            'content' => $this->intro,
            'simple_content' => strip_tags($this->simple_intro),
            'other' => [
                'images' => $this->images,
                'specs' => $this->specs
            ]
        ];
    }
}
