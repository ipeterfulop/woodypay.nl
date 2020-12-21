<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialBlock extends Block
{
    use HasFactory;

    public static function getTranslatedProperties(): array
    {
        return [
            'title',
            'content',
            'person_first_name',
            'person_last_name',
            'person_position',
            'button_label',
            'button_url',
        ];
    }
}
