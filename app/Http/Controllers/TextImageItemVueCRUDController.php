<?php

namespace App\Http\Controllers;

use App\Formdatabuilders\TextImageItemVueCRUDFormdatabuilder;
use App\Http\Requests\SaveTextImageItemVueCRUDRequest;
use App\Dataproviders\TextImageItemVueCRUDDataprovider;
use App\Models\TextImageList;
use Datalytix\VueCRUD\Interfaces\ICRUDController;
use App\Models\TextImageItem;
use Datalytix\VueCRUD\Controllers\VueCRUDControllerBase;

class TextImageItemVueCRUDController extends VueCRUDControllerBase implements ICRUDController
{
    const SUBJECT_CLASS = TextImageItem::class;
    const SUBJECT_SLUG = 'textimageitem';
    const SUBJECT_NAME = 'TextImageItem';
    // an optional constant to allow for using other views
    // the views still have to have the model-manager component
    // (included or copied from the model-manager-inner view)
    // just like in vendor.vue-crud.model-manager, but this way a package
    // update & publish won't overwrite customizations
    //
    // an app-wide default can also be set in config.vuecrud.vueCrudDefaultView
    //const CUSTOM_VIEW_PATH = 'blade.view.path'

    public function store(SaveTextImageItemVueCRUDRequest $request)
    {
        $subject = $request->save();
        $this->setSuccessfulAddPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    public function update(SaveTextImageItemVueCRUDRequest $request, TextImageItem $subject)
    {
        $request->save($subject);
        $this->setSuccessfulModificationPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    public function getSubject($id)
    {
        return TextImageItem::withAllTranslations()->find($id);
    }

    function getElements()
    {
        // returns the result of the getElementsAndCounts method
        // of the related VueCRUDDataprovider class

        $provider = new TextImageItemVueCRUDDataprovider();

        return $provider->getElementsAndCounts();
    }

    public function getSubjectNamePlural()
    {
        $suffix = '';
        if (request()->has('text_image_list_id')) {
            $suffix .= ' - list: "'.TextImageList::find(request()->get('text_image_list_id'))->title.'"';
        }

        return TextImageItem::SUBJECT_NAME_PLURAL.$suffix;
    }

}
