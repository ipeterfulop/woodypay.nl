<?php

namespace App\Http\Requests;

use App\Formdatabuilders\CollectionTextImageListVueCRUDFormdatabuilder;
use App\Models\CollectionTextImageList;
use App\Models\Locale;
use App\Models\TextImageCollectionList;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveCollectionTextImageListVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = CollectionTextImageListVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(CollectionTextImageList $subject = null)
    {
        $dataset = $this->getDataset();
        if ($subject == null) {
            \DB::transaction(function() use ($dataset, &$subject) {
                \Log::info(serialize($dataset));
                $subject = CollectionTextImageList::createWithTranslations($dataset);
                TextImageCollectionList::create([
                    'text_image_list_collection_block_id' => $this->input('text_image_list_collection_block_id'),
                    'text_image_list_id' => $subject->id,
                    'position' => CollectionTextImageList::getFirstAvailablePosition(['text_image_list_collection_block_id' => $this->input('text_image_list_collection_block_id')]),
                ]);
            });
        } else {
            $subject->update($dataset);
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
