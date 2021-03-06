<?php

namespace App\Models;

use Datalytix\KeyValue\canBeTurnedIntoKeyValueCollection;
use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockType extends TranslatableModel implements IRetrievableByTag
{
    use HasFactory, canBeTurnedIntoKeyValueCollection;

    const SUBJECTTYPE_ID = 4;

    protected $table = 'blocktypes';

    protected $fillable = [
        'id',
        'tag',
        'layout_class',
        'item_class',
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

    public function getClassNameFromTag($full = false)
    {
        return $full
            ? '\\App\\Models\\'.str_ireplace('tag_', '', $this->tag)
            : str_ireplace('tag_', '', $this->tag);
    }

    public function getCssName()
    {
        return 'bl-type-'.$this->id;
    }
}
