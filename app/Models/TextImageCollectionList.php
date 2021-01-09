<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Traits\hasPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageCollectionList extends TranslatableModel
{
    use HasFactory, hasPosition;

    protected $table = 'text_image_collection_list';

    protected $fillable = [
        'text_image_list_collection_block_id',
        'text_image_list_id',
        'position',
    ];
    const SUBJECTTYPE_ID = 11;

    protected $with = ['list'];

    public function list()
    {
        return $this->belongsTo(TextImageList::class, 'text_image_list_id');
    }

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return [];
    }

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

    public function remove()
    {
        return \DB::transaction(function() {
            $this->updatePositionOfOtherElementsBeforeDelete();
            $this->delete();
        }) === null;
    }
}
