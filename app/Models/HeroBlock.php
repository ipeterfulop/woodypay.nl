<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBlock extends Block
{
    use HasFactory;

    protected $fillable = [
        'id',
        'text_color',
        'background_color',
        'background_image',
        'background_image_positioning_id',
        'background_gradient',
        'button_background_color',
        'button_text_color',
    ];

    public static function getTranslatedProperties(): array
    {
        return [
            'title',
            'content',
            'button_label',
            'button_url',
        ];
    }
}
