<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributegroup extends TranslatableModel
{
    use HasFactory;

    const SUBJECTTYPE_ID = 102;

    protected $fillable = [
        'id',
        'name',
        'variable_name',
        'created_at',
        'updated_at',
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
