<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageItem extends TranslatableModel
{
    use HasFactory;

    const SUBJECTTYPE_ID = 3;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['title', 'content', 'url'];
    }
}
