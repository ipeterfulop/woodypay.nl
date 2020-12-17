<?php

namespace App\Http\Requests;

use App\Formdatabuilders\AdministratorVueCRUDFormdatabuilder;
use App\Models\Administrator;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveAdministratorVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = AdministratorVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(Administrator $subject = null)
    {
        // a very basic create/update method, you should probably replace it
        // with something customized
        if ($subject == null) {
            $subject = Administrator::create($this->getDataset());
        } else {
            $subject->update($this->getDataset());
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = [
            'name' => $this->input('name'),
            'email' => $this->input('email'),
        ];
        if ($this->has('password')) {
            $result['password'] = \Hash::make($this->input('password'));
        }
        return $result;
    }
}
