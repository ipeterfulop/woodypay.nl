<?php

namespace App\Models;

use App\Helpers\DescendantBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterBlock extends DescendantBlock //implements IHasItemsContainer
{
    use HasFactory;

    protected $table = 'footer_blocks';

    protected $fillable = [
        'site_logo',
        'row_2_content_1',
        'row_2_content_2',
        'row_2_content_3',
        'row_2_content_4',
        'row_3_content_1_copyright',
        'row_3_content_2_imprint',
        'row_3_content_3_terms_of_use',
        'row_3_content_4_privacy',
        'social_icons_text_image_list_id',
    ];

    public $incrementing = false;

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

    public static function getItemsContainerIDField(): string
    {
        return 'social_icons_text_image_list_id';
    }

    public function list()
    {
        return $this->belongsTo(TextImageList::class, 'social_icons_text_image_list_id')->withAllTranslations();
    }

    public function deleteItemsContainer()
    {
        $this->list->remove();
    }

    public function getItemsContainer()
    {
        return $this->list;
    }

    public static function getItemsRouteName()
    {
        return 'vuecrud_textimageitem_index';
    }

    public static function getItemsForeignKey()
    {
        return 'text_image_list_id';
    }
}
