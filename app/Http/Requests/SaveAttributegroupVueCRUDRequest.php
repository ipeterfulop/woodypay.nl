<?php

namespace App\Http\Requests;

use App\Formdatabuilders\AttributegroupVueCRUDFormdatabuilder;
use App\Models\Attributegroup;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveAttributegroupVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = AttributegroupVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(Attributegroup $subject = null)
    {
        // a very basic create/update method, you should probably replace it
        // with something customized
        if ($subject == null) {
            $subject = Attributegroup::create($this->getDataset());
        } else {
            $subject->update($this->getDataset());
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = $this->getBaseDatasetFromRequest(Attributegroup::class);
        // this is very basic, and will probably not suffice except for very simple models
        return $result;
    }
}
