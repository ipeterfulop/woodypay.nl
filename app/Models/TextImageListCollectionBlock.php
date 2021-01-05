<?php

namespace App\Models;

use App\Helpers\DescendantBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageListCollectionBlock extends DescendantBlock
{
    use HasFactory;

    protected $fillable = [
        'id',
        'text_color_selected_list',
        'background_color_selected_list',
        'background_gradient_selected_list',
    ];

    protected $table = 'text_image_list_collection_blocks';

    public $incrementing = false;

    public static function getTranslatedProperties(): array
    {
        return ['title', 'content'];
    }

    public function lists()
    {
        return $this->hasManyThrough(
            TextImageList::class,
            TextImageCollectionList::class,
            'text_image_list_id',
            'id',
            'id',
            'text_image_list_collection_block_id',
        );
    }


    public function getItemsLink()
    {
        return '<a href="'
            .route('vuecrud_textimagelist_index', ['text_image_list_collection_block_id' => $this->id])
            .'">'
            .__('Manage collections')
            .'</a>';
    }

}
