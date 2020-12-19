<?php

namespace App\Http\Requests;

use App\Formdatabuilders\PageVueCRUDFormdatabuilder;
use App\Models\Page;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SavePageVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = PageVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(Page $subject = null)
    {
        // a very basic create/update method, you should probably replace it
        // with something customized
        if ($subject == null) {
            $subject = Page::create($this->getDataset());
        } else {
            $subject->update($this->getDataset());
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = $this->getBaseDatasetFromRequest(Page::class);
        // this is very basic, and will probably not suffice except for very simple models
        return $result;
    }
}
