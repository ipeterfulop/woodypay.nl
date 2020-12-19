<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockType extends TranslatableModel implements IRetrievableByTag
{
    use HasFactory;

    protected $table = 'blocktypes';

    protected $fillable = [
        'id',
        'tag'
    ];

    public static function getSubjecttypeId()
    {
        // TODO: Implement getSubjecttypeId() method.
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
