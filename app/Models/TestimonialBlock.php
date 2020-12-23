<?php

namespace App\Models;

use App\Helpers\DescendantBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TestimonialBlock extends DescendantBlock
{
    use HasFactory;
    protected $fillable = [
        'id',
        'person_photo'
    ];

    protected $table = 'testimonial_blocks';

    public $incrementing = false;

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
