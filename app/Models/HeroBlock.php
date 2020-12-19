<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBlock extends Block
{
    use HasFactory;

    public static function getTranslatedProperties(): array
    {
        return [
            'title',
            'content',
            'button_label',
            'button_url',
        ];
    }

    public static function getBlockTypeTag(): ?string
    {

    }
}
