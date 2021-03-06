<?php

namespace App\Models;

use App\Helpers\DescendantBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CTABlock extends DescendantBlock
{
    use HasFactory;

    protected $table = 'cta_blocks';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'background_image',
        'spacing_id',
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

    public function spacing()
    {
        return $this->belongsTo(Spacing::class);
    }

    public function spacingCssStyle()
    {
        $spacing = $this->spacing == null ? '4' : $this->spacing->size_in_rems;
        return ' padding-top: '.$spacing.'rem; padding-bottom: '.$spacing.'rem;';
    }

}
