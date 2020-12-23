<?php

namespace App\Models;

use App\Helpers\DescendantBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageListBlock extends DescendantBlock
{
    use HasFactory;

    protected $table = 'text_image_list_blocks';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'topic_image',
        'list_id'
    ];


}
