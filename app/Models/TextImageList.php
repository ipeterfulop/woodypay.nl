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

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['title', 'content', 'topic_image'];
    }

    public function items()
    {
        return $this->hasMany(TextImageItem::class);
    }

    public function remove()
    {
        return \DB::transaction(function() {
            foreach($this->items as $item) {
                $item->remove();
            }
            parent::remove();
        }) === null;
    }
}
