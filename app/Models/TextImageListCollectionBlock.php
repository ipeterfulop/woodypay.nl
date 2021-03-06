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

    //won't work with global scopes, Laravel feature shortage
    public function lists()
    {
        return $this->hasManyThrough(
            CollectionTextImageList::class,
            TextImageCollectionList::class,
            'text_image_list_collection_block_id',
            'id',
            'id',
            'text_image_list_id',
        )->orderBy('_ptr.position', 'asc');
    }

    public function getLists()
    {
        return CollectionTextImageList::where('text_image_list_collection_block_id', '=', $this->id)->orderBy('_ptr.position')->get();
    }


    public function getItemsLink()
    {
        return '<a href="'
            .route('vuecrud_textimagelist_index', ['text_image_list_collection_block_id' => $this->id])
            .'">'
            .__('Manage collections')
            .'</a>';
    }

    public function deleteItemsContainer()
    {
        return \DB::transaction(function() {
            TextImageCollectionList::where('text_image_list_collection_block_id', '=', $this->id)->delete();
            foreach($this->getLists() as $list) {
                $list->remove();
            }
        }) === null;
    }
}
