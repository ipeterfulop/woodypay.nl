<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageCollectionList extends TranslatableModel
{
    use HasFactory;

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
}
