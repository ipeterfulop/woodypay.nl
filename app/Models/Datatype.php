<?php

namespace App\Models;

use Database\Seeders\SubjecttypesSeeder;
use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Datatype extends TranslatableModel
{
    use HasFactory;

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
