<?php

namespace App\Http\Requests;

use App\Formdatabuilders\UseractionVueCRUDFormdatabuilder;
use App\Models\Useraction;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveUseractionVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = UseractionVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(Useraction $subject = null)
    {
        // a very basic create/update method, you should probably replace it
        // with something customized
        if ($subject == null) {
            $subject = Useraction::create($this->getDataset());
        } else {
            $subject->update($this->getDataset());
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = $this->getBaseDatasetFromRequest(Useraction::class);
        // this is very basic, and will probably not suffice except for very simple models
        return $result;
    }
}
