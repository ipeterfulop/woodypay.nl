<?php


namespace App\Formdatabuilders;


use App\Models\CollectionTextImageList;
use App\Models\Locale;
use App\Models\TextImageListCollectionBlock;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\RichttextQuillVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\SelectVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\TextVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\VueCRUDFormdatabuilder;

class CollectionTextImageListVueCRUDFormdatabuilder extends VueCRUDFormdatabuilder
{
    /**
     * @return Illuminate\Support\Collection;
     * returns a collection of VueCRUDFormfield descendants that
     * define what the edit/create forms will contain
     */
    protected static function getFields()
    {
        $fields = [];
        $fields['text_image_list_collection_block_id'] = (new SelectVueCRUDFormfield())
            ->setLabel('Block')
            ->setMandatory(true)
            ->setContainerClass('w-full hidden-important')
            ->setDefault(request()->get('text_image_list_collection_block_id'))
            ->setOnlyWhenCreating(true)
            ->setValuesetClass(TextImageListCollectionBlock::class);

        foreach (Locale::all() as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
        }
        return collect($fields);
    }

    public function __construct(CollectionTextImageList $subject = null, $defaults = [])
    {
        $this->subject = $subject;
        $this->defaults = $defaults;
    }
}