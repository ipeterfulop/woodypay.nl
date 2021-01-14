<?php


namespace App\Formdatabuilders;


use App\Models\Locale;
use App\Models\Page;
use App\Rules\PageUrlUnique;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\TextVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\VueCRUDFormdatabuilder;

class PageVueCRUDFormdatabuilder extends VueCRUDFormdatabuilder
{
    /**
     * @return Illuminate\Support\Collection;
     * returns a collection of VueCRUDFormfield descendants that
     * define what the edit/create forms will contain
     */
    protected static function getFields()
    {
        $result = [];
        foreach (Locale::all() as $locale) {
            $result[$locale->getTranslatedPropertyName('name')] = (new TextVueCRUDFormfield())
                ->setLabel('Name ('.$locale->uppercase_id.')')
                ->setContainerClass('w-1/2')
                ->setMandatory(true);
            $result[$locale->getTranslatedPropertyName('url')] = (new TextVueCRUDFormfield())
                ->setLabel('Relative URL without language code and starting slash (e.g. privacy) ('.$locale->uppercase_id.')')
                ->setContainerClass('w-1/2')
                ->setMandatory(true);
        }
        return collect($result);
    }

    public function __construct(Page $subject = null, $defaults = [])
    {
        $this->subject = $subject;
        $this->defaults = $defaults;
    }
}