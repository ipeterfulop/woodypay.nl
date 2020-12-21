<?php

namespace App\Http\Controllers;

use App\Formdatabuilders\BlockVueCRUDFormdatabuilder;
use App\Http\Requests\SaveBlockVueCRUDRequest;
use App\Dataproviders\BlockVueCRUDDataprovider;
use Datalytix\VueCRUD\Interfaces\ICRUDController;
use App\Models\Block;
use Datalytix\VueCRUD\Controllers\VueCRUDControllerBase;

class BlockVueCRUDController extends VueCRUDControllerBase implements ICRUDController
{
    const SUBJECT_CLASS = Block::class;
    const SUBJECT_SLUG = 'block';
    const SUBJECT_NAME = 'Block';
    // an optional constant to allow for using other views
    // the views still have to have the model-manager component
    // (included or copied from the model-manager-inner view)
    // just like in vendor.vue-crud.model-manager, but this way a package
    // update & publish won't overwrite customizations
    //
    // an app-wide default can also be set in config.vuecrud.vueCrudDefaultView
    //const CUSTOM_VIEW_PATH = 'blade.view.path'

    public function store(SaveBlockVueCRUDRequest $request)
    {
        if (request()->input('currentStep') == 1) {
            return response('OK');
        }
        $subject = $request->save();
        $this->setSuccessfulAddPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    public function update(SaveBlockVueCRUDRequest $request, Block $subject)
    {
        $request->save($subject);
        $this->setSuccessfulModificationPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    function getElements()
    {
        // returns the result of the getElementsAndCounts method
        // of the related VueCRUDDataprovider class

        $provider = new BlockVueCRUDDataprovider();

        return $provider->getElementsAndCounts();
    }

    public function getSubject($id)
    {
        return Block::withPosition()->find($id);
    }

}
