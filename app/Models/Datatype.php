<?php

namespace App\Models;

use Database\Seeders\SubjecttypesSeeder;
use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datatype extends TranslatableModel
{
    use HasFactory;

    const INTEGER_ID = 1;
    const FLOAT_ID = 2;
    const STRING_ID = 3;
    const TEXT_ID = 4;
    const BOOLEAN_ID = 5;
    const DATE_ID = 6;
    const TIME_ID = 7;
    const COLOR_ID = 8;
    const IMAGE_ID = 9;

    const SUBJECTTYPE_ID = 101;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['name'];
    }
}
