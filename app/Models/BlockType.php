<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockType extends TranslatableModel implements IRetrievableByTag
{
    use HasFactory;

    const SUBJECTTYPE_ID = 4;

    protected $table = 'blocktypes';

    protected $fillable = [
        'id',
        'tag'
    ];

    public static function getSubjecttypeId()
    {
        return self::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['name'];
    }

    public static function findByTag(string $tag)
    {
        return self::where('tag', '=', $tag)->first();
    }
}
