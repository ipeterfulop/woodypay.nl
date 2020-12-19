<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CTABlock extends Block
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
}
