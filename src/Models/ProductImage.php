<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * 商品圖片
 *
 * @param int id 編號
 * @param int item_id 商品編號
 * @param string path 圖片路徑
 * @param string data_type 資料類型
 * @param string description 描述
 * @param Carbon created_at 建立時間
 * @param Carbon updated_at 更新時間
 */
class ProductImage extends Model
{
    use HasFactory;

    protected $connection = 'harrison_laravel_product';

    protected $table = 'pj_product_image';

    protected $fillable = [
        'item_id',
        'path',
        'data_type',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'item_id');
    }
}
