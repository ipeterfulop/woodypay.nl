<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TextImageList extends TranslatableModel
{
    use VueCRUDManageable;

    const SUBJECTTYPE_ID = 3;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['title', 'content', 'topic_image'];
    }

    public static function getVueCRUDIndexColumns()
    {
        // TODO: Implement getVueCRUDIndexColumns() method.
    }

    public static function getVueCRUDSortingIndexColumns()
    {
        // TODO: Implement getVueCRUDSortingIndexColumns() method.
    }

    public function getVueCRUDDetailsFields()
    {
        // TODO: Implement getVueCRUDDetailsFields() method.
    }

    public static function getVueCRUDIndexFilters()
    {
        // TODO: Implement getVueCRUDIndexFilters() method.
    }
}
