<?php

namespace App\Models;

use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;
use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Positioning extends TranslatableModel
{
    use canBeTurnedIntoKeyValueCollection;
    use HasFactory;

    const SUBJECTTYPE_ID = 5;

    protected $fillable = [
        'code',
        'is_horizontal',
        'is_vertical',
    ];

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['name'];
    }

    public static function getBackgroundPositioningOptions()
    {
        return self::where('is_horizontal', '=', 1)
            ->where('is_vertical', '=', 1)
            ->get()
            ->pluck('name', 'id');
    }

    public static function getHorizontalPositioningOptions()
    {
        return self::where('is_horizontal', '=', 1)
            ->where('is_vertical', '=', 0)
            ->get()
            ->pluck('name', 'id');
    }

    public static function getVerticalPositioningOptions()
    {
        return self::where('is_horizontal', '=', 0)
            ->where('is_vertical', '=', 1)
            ->get()
            ->pluck('name', 'id');
    }

}
