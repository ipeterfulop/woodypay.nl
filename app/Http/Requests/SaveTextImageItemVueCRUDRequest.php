<?php

namespace App\Http\Requests;

use App\Formdatabuilders\TextImageItemVueCRUDFormdatabuilder;
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
        // a very basic create/update method, you should probably replace it
        // with something customized
        if ($subject == null) {
            $subject = TextImageItem::create($this->getDataset());
        } else {
            $subject->update($this->getDataset());
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = $this->getBaseDatasetFromRequest(TextImageItem::class);
        // this is very basic, and will probably not suffice except for very simple models
        return $result;
    }
}
