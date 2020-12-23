<?php


namespace App\Formdatabuilders;


use App\Models\Locale;
use App\Models\TextImageItem;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\ImagePickerVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\RichttextQuillVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\StaticVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\TextVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\VueCRUDFormdatabuilder;

class TextImageItemVueCRUDFormdatabuilder extends VueCRUDFormdatabuilder
{
    /**
     * @return Illuminate\Support\Collection;
     * returns a collection of VueCRUDFormfield descendants that
     * define what the edit/create forms will contain
     */
    protected static function getFields()
    {
        $result = [];
        $result['text_image_list_id'] = (new StaticVueCRUDFormfield())
            ->setDefault(request()->get('text_image_list_id'))
            ->setContainerClass('hidden-important');
        $result['topic_image'] = (new ImagePickerVueCRUDFormfield())
            ->setLabel('Image')
            ->setContainerClass('w-full');
        $result['fa_icon_classes'] = (new TextVueCRUDFormfield())
            ->setLabel('FontAwesome icon class')
            ->setContainerClass('w-full');
        foreach (Locale::all() as $locale) {
            $result[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $result[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
        }
        return collect($result);
    }

    public function __construct(TextImageItem $subject = null, $defaults = [])
    {
        $this->subject = $subject;
        $this->defaults = $defaults;
    }
}