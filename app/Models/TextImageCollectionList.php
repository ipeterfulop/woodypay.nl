<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageCollectionList extends Model
{
    use HasFactory;

    protected $table = 'text_image_collection_list';

    protected $fillable = [
        'text_image_list_collection_block_id',
        'text_image_list_id',
        'position',
    ];
}
