<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Indexfilters\SelectVueCRUDIndexfilter;
use Datalytix\VueCRUD\Traits\hasPosition;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageItem extends TranslatableModel
{
    use HasFactory, VueCRUDManageable, hasPosition;

    const SUBJECTTYPE_ID = 11;

    const SUBJECT_ID = 'textimageitem';
    const SUBJECT_NAME = 'Text+image item';
    const SUBJECT_NAME_PLURAL = 'Text+image items';

    protected $fillable = [
        'text_image_list_id',
        'position',
        'topic_image',
        'fa_icon_classes'
    ];

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['title', 'content', 'url'];
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'title' => __('Title'),
            'content' => __('Content'),
        ];
    }

    public static function getVueCRUDSortingIndexColumns()
    {
        return [];
    }

    public function getVueCRUDDetailsFields()
    {
        return [
            'title' => __('Title'),
            'content' => __('Content'),
            'url' => __('URL'),
        ];
    }

    public static function getVueCRUDIndexFilters()
    {
        $result = [];
        $result['text_image_list_id'] = new SelectVueCRUDIndexfilter('text_image_list_id', 'Parent list', -1);
        $result['text_image_list_id']->setValueSet(TextImageList::all()->pluck('id', 'id'));
        $result['text_image_list_id']->setContainerClass('hidden');

        return $result;
    }

    /**
     * @return array
     * this function returns a list of fields that are used as restrictions when changing position
     * for example if it returns ['role_id'], every non-static positioning function will
     * only look for elements with the same role_id as the subject
     */
    public static function getRestrictingFields()
    {
        return ['text_image_list_id'];
    }
}
