<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageList extends TranslatableModel
{
    const SUBJECT_SLUG = 'textimagelist';
    const SUBJECT_NAME = 'Text+image list';
    const SUBJECT_NAME_PLURAL = 'Text+image lists';
    const SUBJECTTYPE_ID = 3;

    protected $table = 'text_image_lists';

    protected $with = ['items'];

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return [
            'title',
            'content',
            'topic_image',
        ];
    }

    public function items()
    {
        return $this->hasMany(TextImageItem::class, 'text_image_list_id');
    }

    public function remove()
    {
        return \DB::transaction(
                function () {
                    foreach ($this->items as $item) {
                        $item->remove();
                    }
                    foreach (TextImageCollectionList::where('text_image_list_id', '=', $this->id)->get() as $c) {
                        $c->remove();
                    }
                    parent::remove();
                }
            ) === null;
    }

    public static function modifyModellistButtons($buttons)
    {
        unset($buttons['details']);

        return $buttons;
    }
}
