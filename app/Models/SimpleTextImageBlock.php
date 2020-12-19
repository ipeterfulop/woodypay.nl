<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SimpleTextImageBlock extends Block
{
    use HasFactory;

    public static function getSubjecttypeId()
    {
        // TODO: Implement getSubjecttypeId() method.
    }

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

    static function getBlockTypeTag(): string
    {
    }
}
