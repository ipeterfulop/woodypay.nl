<?php

namespace App\Http\Requests;

use App\Formdatabuilders\MemberVueCRUDFormdatabuilder;
use App\Models\Member;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveMemberVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = MemberVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(Member $subject = null)
    {
        // a very basic create/update method, you should probably replace it
        // with something customized
        if ($subject == null) {
            $subject = Member::create($this->getDataset());
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
