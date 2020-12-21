<?php

namespace App\Http\Requests;

use App\Formdatabuilders\BlockVueCRUDFormdatabuilder;
use App\Models\Block;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveBlockVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = BlockVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(Block $subject = null)
    {
        // a very basic create/update method, you should probably replace it
        // with something customized
        if ($subject == null) {
            $subject = Block::create($this->getDataset());
        } else {
            $subject->update($this->getDataset());
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = $this->getBaseDatasetFromRequest(Block::class);
        // this is very basic, and will probably not suffice except for very simple models
        return $result;
    }
}
