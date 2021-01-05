<?php


namespace App\Formdatabuilders;


use App\Models\TextImageList;
use Datalytix\VueCRUD\Formdatabuilders\VueCRUDFormdatabuilder;

class TextImageListVueCRUDFormdatabuilder extends VueCRUDFormdatabuilder
{
    /**
     * @return Illuminate\Support\Collection;
     * returns a collection of VueCRUDFormfield descendants that
     * define what the edit/create forms will contain
     */
    protected static function getFields()
    {
        return collect([]);
    }

    public function __construct(TextImageList $subject = null, $defaults = [])
    {
        $this->subject = $subject;
        $this->defaults = $defaults;
    }
}