<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * 商品分類關聯
 * @param int id 編號
 * @param int data_id 資料 id e.g. 商品
 * @param int category_id 類別 id
 * @param int item_id 項目 id e.g. 商品編號 1
 */
class RelationShipCatory extends Model
{
    use HasFactory;

    protected $table = 'pj_relationship_category';

    protected $fillable = [
        'data_id',
        'category_id',
        'item_id'
    ];
}
