<?php


namespace App\Models;


use App\Traits\HasPositionThroughPivot;
use Datalytix\VueCRUD\Indexfilters\TextVueCRUDIndexfilter;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;

class CollectionTextImageList extends TextImageList
{
    use VueCRUDManageable, HasPositionThroughPivot;

    protected $table = 'text_image_lists';

    protected $appends = [
        'items_label'
    ];

    /**
     * @return array
     * this function returns a list of fields that are used as restrictions when changing position
     * for example if it returns ['role_id'], every non-static positioning function will
     * only look for elements with the same role_id as the subject
     */
    public static function getRestrictingFields()
    {
        return ['text_image_list_collection_block_id'];
    }

    public static function getPositioningPivotForeignKey()
    {
        return 'text_image_list_id';
    }

    public static function getPositioningPivotModelFields()
    {
        return ['position', 'text_image_list_collection_block_id'];
    }

    public static function getPositioningPivotModelclass()
    {
        return TextImageCollectionList::class;
    }

    public function getItemsLabelAttribute()
    {
        return '<a href="'.route('vuecrud_textimageitem_index', [
            'text_image_list_id' => $this->id,
            'referer' => static::getVueCRUDBackreferenceParameterValue(['text_image_list_collection_block_id']),
        ]).'">'.__('Manage items').'</a>';
;
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'title' => __('Title'),
            'items_label' => __('Items'),
        ];
    }

    public static function getVueCRUDSortingIndexColumns()
    {
        return [];
    }

    public function getVueCRUDDetailsFields()
    {
        return [];
    }

    public static function getVueCRUDIndexFilters()
    {
        $result = [];
        $result['text_image_list_collection_block_id'] = new TextVueCRUDIndexfilter('text_image_list_collection_block_id', '', null);
        $result['text_image_list_collection_block_id']->setContainerClass('hidden-important');
        return $result;
    }

    public static function getVueCRUDParentIndexLink()
    {
        if (request()->has('text_image_list_collection_block_id')) {
            $block = Block::find(request()->get('text_image_list_collection_block_id'));
            return [
                'url' => route('vuecrud_block_index', ['page_id' => $block->page_id]),
                'label' => __('Back to').' '.mb_strtolower(__('Blocks'))
            ];
        }

        return null;
    }
}