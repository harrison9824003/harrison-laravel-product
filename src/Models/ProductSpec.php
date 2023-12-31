<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSpec extends Model
{
    use HasFactory;

    protected $table = "pj_product_spec";

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
