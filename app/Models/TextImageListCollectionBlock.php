<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageListCollectionBlock extends Block
{
    use HasFactory;

    const SUBJECTTYPE_ID = 8;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['title', 'content', 'topic_image'];
    }
}
