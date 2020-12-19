<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

abstract class Block extends TranslatableModel
{
    use HasFactory;

    const SUBJECTTYPE_ID = 1;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        // TODO: Implement getTranslatedProperties() method.
    }

    public static function getBlockTypeTag(): ?string
    {
        return 'tag_' . basename(static::class);
    }

}
