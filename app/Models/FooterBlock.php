<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterBlock extends Block
{
    use HasFactory;

    public static function getTranslatedProperties(): array
    {
        return [
            'site_logo',
            'row_2_content_1',
            'row_2_content_2',
            'row_2_content_3',
            'row_2_content_4',
            'row_3_content_1_copyright',
            'row_3_content_2_imprint',
            'row_3_content_3_terms_of_use',
            'row_3_content_4_privacy',
        ];
    }
}