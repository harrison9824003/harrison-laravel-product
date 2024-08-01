<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 商品分類
 * @param int id 編號
 * @param int parent_id 父類別編號
 * @param string name 分類名稱
 * @param int order 排序
 * @param bool display 是否顯示
 * @param Carbon created_at 建立時間
 * @param Carbon updated_at 更新時間
 */
class Category extends Model
{
    use HasFactory;

    protected $table = 'pj_category';
    protected $fillable = [
        'parent_id',
        'name',
        'order',
        'display'
    ];

    protected $casts = [
        'display' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    public function category()
    {
        return $this->hasMany(RelationShipCatory::class, 'category_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class);
    }

    public function childern()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }
}
