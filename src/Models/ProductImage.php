<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Harrison\LaravelProduct\Traits\HasModelId;

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

    public function datatype()
    {
        return $this->belongsTo(DataType::class, 'id', 'data_id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'id', 'item_id');
    }
}
