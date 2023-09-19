<?php

namespace Harrison\LaravelProduct\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Harrison\LaravelProduct\Traits\HasModelId;

class DataTypeFolder extends Model
{
    use HasFactory;
    use HasModelId;

    protected $table = 'pj_datatype_folder';

    protected $fillable = [
        'name',
        'models'
    ];
}
