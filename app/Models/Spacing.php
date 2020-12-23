<?php

namespace App\Models;

use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;
use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spacing extends TranslatableModel
{
    use canBeTurnedIntoKeyValueCollection;

    const SUBJECTTYPE_ID = 10;

    protected $fillable = [
        'id',
        'size_in_rems',
    ];

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['name'];
    }
}
