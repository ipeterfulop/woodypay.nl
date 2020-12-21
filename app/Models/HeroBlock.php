<?php

namespace App\Models;

use App\Helpers\DescendantBlock;
use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HeroBlock extends DescendantBlock
{
    use HasFactory;

    protected $table = 'hero_blocks';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'background_image',
        'background_image_positioning_id',
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