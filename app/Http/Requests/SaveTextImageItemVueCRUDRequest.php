<?php

namespace App\Http\Requests;

use App\Formdatabuilders\TextImageItemVueCRUDFormdatabuilder;
use App\Models\Locale;
use App\Models\TextImageItem;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveTextImageItemVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = TextImageItemVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(TextImageItem $subject = null)
    {
        $dataset = $this->getDataset();
        if ($subject == null) {
            $dataset['position'] = TextImageItem::withoutTranslations()->where(['text_image_list_id' => $this->input('text_image_list_id')])->max('position') + 1;
            $dataset['text_image_list_id'] = $this->input('text_image_list_id');
            $subject = TextImageItem::createWithTranslations($dataset);
        } else {
            $subject->updateWithTranslations($dataset);
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = [
            'text_image_list_id' => $this->input('text_image_list_id'),
        ];
        foreach (Locale::all() as $locale) {
            $result[$locale->getTranslatedPropertyName('title')] = $this->input($locale->getTranslatedPropertyName('title'));
            $result[$locale->getTranslatedPropertyName('content')] = $this->input($locale->getTranslatedPropertyName('content'));
        }
        // this is very basic, and will probably not suffice except for very simple models
        return $result;
    }
}
