<?php

namespace App\Http\Controllers;

use App\Formdatabuilders\CollectionTextImageListVueCRUDFormdatabuilder;
use App\Http\Requests\SaveCollectionTextImageListVueCRUDRequest;
use App\Dataproviders\CollectionTextImageListVueCRUDDataprovider;
use App\Models\Block;
use Datalytix\VueCRUD\Interfaces\ICRUDController;
use App\Models\CollectionTextImageList;
use Datalytix\VueCRUD\Controllers\VueCRUDControllerBase;

class CollectionTextImageListVueCRUDController extends VueCRUDControllerBase implements ICRUDController
{
    const SUBJECT_CLASS = CollectionTextImageList::class;
    const SUBJECT_SLUG = 'collectiontextimagelist';
    const SUBJECT_NAME = 'CollectionTextImageList';
    // an optional constant to allow for using other views
    // the views still have to have the model-manager component
    // (included or copied from the model-manager-inner view)
    // just like in vendor.vue-crud.model-manager, but this way a package
    // update & publish won't overwrite customizations
    //
    // an app-wide default can also be set in config.vuecrud.vueCrudDefaultView
    //const CUSTOM_VIEW_PATH = 'blade.view.path'

    public function store(SaveCollectionTextImageListVueCRUDRequest $request)
    {
        $subject = $request->save();
        $this->setSuccessfulAddPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    public function update(SaveCollectionTextImageListVueCRUDRequest $request, CollectionTextImageList $subject)
    {
        $request->save($subject);
        $this->setSuccessfulModificationPopupMessageInSession();

        return $this->getModificationResponse($subject);
    }

    function getElements()
    {
        // returns the result of the getElementsAndCounts method
        // of the related VueCRUDDataprovider class

        $provider = new CollectionTextImageListVueCRUDDataprovider();

        return $provider->getElementsAndCounts();
    }

    public function getSubjectNamePlural()
    {
        $suffix = '';
        if (request()->has('text_image_list_collection_block_id')) {
            $suffix = ' - '.Block::find(request()->get('text_image_list_collection_block_id'))->internal_name;
        }

        return CollectionTextImageList::SUBJECT_NAME_PLURAL.$suffix;
    }

    public function getSubject($id)
    {
        $class = static::SUBJECT_CLASS;

        return $class::withAllTranslations()->find($id);
    }

}
