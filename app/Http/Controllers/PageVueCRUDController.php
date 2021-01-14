<?php

namespace App\Http\Controllers;

use App\Formdatabuilders\PageVueCRUDFormdatabuilder;
use App\Http\Requests\SavePageVueCRUDRequest;
use App\Dataproviders\PageVueCRUDDataprovider;
use Datalytix\VueCRUD\Interfaces\ICRUDController;
use App\Models\Page;
use Datalytix\VueCRUD\Controllers\VueCRUDControllerBase;

class PageVueCRUDController extends VueCRUDControllerBase implements ICRUDController
{
    const SUBJECT_CLASS = Page::class;
    const SUBJECT_SLUG = 'page';
    const SUBJECT_NAME = 'Page';
    // an optional constant to allow for using other views
    // the views still have to have the model-manager component
    // (included or copied from the model-manager-inner view)
    // just like in vendor.vue-crud.model-manager, but this way a package
    // update & publish won't overwrite customizations
    //
    // an app-wide default can also be set in config.vuecrud.vueCrudDefaultView
    //const CUSTOM_VIEW_PATH = 'blade.view.path'

    public function store(SavePageVueCRUDRequest $request)
    {
        $subject = $request->save();
        $this->setSuccessfulAddPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    public function update(SavePageVueCRUDRequest $request, Page $subject)
    {
        $request->save($subject);
        $this->setSuccessfulModificationPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    function getElements()
    {
        // returns the result of the getElementsAndCounts method
        // of the related VueCRUDDataprovider class

        $provider = new PageVueCRUDDataprovider();

        return $provider->getElementsAndCounts();
    }

    public function getSubject($id)
    {
        return Page::withAllTranslations()->find($id);
    }

}
