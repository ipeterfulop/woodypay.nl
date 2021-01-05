<?php

namespace App\Http\Requests;

use App\Formdatabuilders\TextImageListVueCRUDFormdatabuilder;
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
        // a very basic create/update method, you should probably replace it
        // with something customized
        if ($subject == null) {
            $subject = TextImageList::create($this->getDataset());
        } else {
            $subject->update($this->getDataset());
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = $this->getBaseDatasetFromRequest(TextImageList::class);
        // this is very basic, and will probably not suffice except for very simple models
        return $result;
    }
}
