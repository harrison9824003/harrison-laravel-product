<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Harrison\LaravelProduct\Traits\HasModelId;

/**
 * 商品圖片
 * @param int id 編號
 * @param int data_id 資料編號
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
    use HasModelId;

    protected $table = 'pj_image';

    protected $fillable = [
        'data_id',
        'item_id',
        'path',
        'data_type',
        'description',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function datatype()
    {
        return $this->belongsTo(DataType::class, 'id', 'data_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'item_id');
    }
}
