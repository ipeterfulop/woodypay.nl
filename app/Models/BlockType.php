<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockType extends TranslatableModel implements IRetrievableByTag
{
    use HasFactory;

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
        // TODO: Implement findByTag() method.
    }
}
