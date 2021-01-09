<?php

namespace App\Http\Requests;

use App\Formdatabuilders\TextImageListVueCRUDFormdatabuilder;
use App\Models\Locale;
use App\Models\TextImageCollectionList;
use App\Models\TextImageList;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveTextImageListVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = TextImageListVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(TextImageList $subject = null)
    {
        $dataset = $this->getDataset();
        if ($subject == null) {
            $subject = TextImageList::createWithTranslations($this->getDataset());
            if ($this->has('text_image_list_collection_block_id')) {
                $coll = TextImageCollectionList::create([
                    'text_image_list_collection_block_id' => $this->input('text_image_list_collection_block_id'),
                    'text_image_list_id' => $subject->id,
                    'position' => TextImageCollectionList::getFirstAvailablePosition([
                        'text_image_list_collection_block_id' => $this->input('text_image_list_collection_block_id')
                    ]),
                ]);
            }

        } else {
            $subject->updateWithTranslations($dataset);
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = [];
        foreach (Locale::all() as $locale) {
            $result[$locale->getTranslatedPropertyName('title')] = $this->input($locale->getTranslatedPropertyName('title'));
            $result[$locale->getTranslatedPropertyName('content')] = $this->input($locale->getTranslatedPropertyName('content'));
        }
        return $result;
    }
}
