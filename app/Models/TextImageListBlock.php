<?php

namespace App\Models;

use App\Helpers\DescendantBlock;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageListBlock extends DescendantBlock implements IHasItemsContainer
{
    use HasFactory;

    protected $table = 'text_image_list_blocks';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'topic_image',
        'list_id',
    ];

    public static function getItemsContainerIDField(): string
    {
        return 'list_id';
    }

    public function list()
    {
        return $this->belongsTo(TextImageList::class, 'list_id')->withAllTranslations();
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
