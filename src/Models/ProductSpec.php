<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 商品規格
 * @param int id 編號
 * @param int category_id 規格類別 id
 * @param int product_id 商品 id
 * @param int reserve_num 預設庫存
 * @param int low_reserve_num 最低庫存
 * @param int volume 體積
 * @param int weight 重量
 * @param int order 排序
 * @param Carbon created_at 建立時間
 * @param Carbon updated_at 更新時間
 */
class ProductSpec extends Model
{
    use HasFactory;

    protected $table = "pj_product_spec";

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    protected $fillable = [
        'category_id',
        'product_id',
        'reserve_num',
        'low_reserve_num',
        'volume',
        'weight',
        'order'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(SpecCategory::class);
    }

    public function scopeCart($query, $product_id, $category_id)
    {
        return $query->where('product_id', $product_id)->where('category_id', $category_id);
    }
}
