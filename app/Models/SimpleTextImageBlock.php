<?php

namespace App\Models;

use App\Helpers\DescendantBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleTextImageBlock extends DescendantBlock
{
    use HasFactory;

    protected $table = 'simple_text_image_blocks';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'topic_image_border_color',
        'topic_image_horizontal_positioning_id',
    ];

    public static function getTranslatedProperties(): array
    {
        return [
            'title',
            'content',
            'button_label',
            'button_url',
            'topic_image',
        ];
    }

    public function positioning()
    {
        return $this->belongsTo(Positioning::class, 'topic_image_horizontal_positioning_id');
    }
}
