<?php

namespace App\Http\Controllers;

use App\Formdatabuilders\TextImageListVueCRUDFormdatabuilder;
use App\Http\Requests\SaveTextImageListVueCRUDRequest;
use App\Dataproviders\TextImageListVueCRUDDataprovider;
use Datalytix\VueCRUD\Interfaces\ICRUDController;
use App\Models\TextImageList;
use Datalytix\VueCRUD\Controllers\VueCRUDControllerBase;

class TextImageListVueCRUDController extends VueCRUDControllerBase implements ICRUDController
{
    const SUBJECT_CLASS = TextImageList::class;
    const SUBJECT_SLUG = 'textimagelist';
    const SUBJECT_NAME = 'TextImageList';
    // an optional constant to allow for using other views
    // the views still have to have the model-manager component
    // (included or copied from the model-manager-inner view)
    // just like in vendor.vue-crud.model-manager, but this way a package
    // update & publish won't overwrite customizations
    //
    // an app-wide default can also be set in config.vuecrud.vueCrudDefaultView
    //const CUSTOM_VIEW_PATH = 'blade.view.path'

    public function store(SaveTextImageListVueCRUDRequest $request)
    {
        $subject = $request->save();
        $this->setSuccessfulAddPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    public function update(SaveTextImageListVueCRUDRequest $request, TextImageList $subject)
    {
        $request->save($subject);
        $this->setSuccessfulModificationPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    function getElements()
    {
        // returns the result of the getElementsAndCounts method
        // of the related VueCRUDDataprovider class

        $provider = new TextImageListVueCRUDDataprovider();

        return $provider->getElementsAndCounts();
    }

}
