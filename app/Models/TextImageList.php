<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageList extends TranslatableModel
{
    const SUBJECTTYPE_ID = 3;

    protected $table = 'text_image_lists';

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['title', 'content', 'topic_image'];
    }
}
