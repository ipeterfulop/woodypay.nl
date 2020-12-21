<?php

namespace App\Models;

use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;
use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spacing extends TranslatableModel
{
    use canBeTurnedIntoKeyValueCollection;
    use HasFactory;

    const SUBJECTTYPE_ID = 10;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['name'];
    }
}
