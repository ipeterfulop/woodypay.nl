<?php

namespace App\Dataproviders;

use App\Models\CollectionTextImageList;
use Illuminate\Support\Collection;
use Datalytix\VueCRUD\Dataproviders\VueCRUDDataproviderBase;
use Datalytix\VueCRUD\Dataproviders\IVueCRUDDataprovider;

class CollectionTextImageListVueCRUDDataprovider extends VueCRUDDataproviderBase implements IVueCRUDDataprovider
{

    function getBaseQuery()
    {
        return CollectionTextImageList::withAllTranslations();
    }

    function getQuery()
    {
        $query = $this->getBaseQuery();
        $query = $this->addQueryFilters($query, CollectionTextImageList::class);

        return $query;
    }

    protected function getSortingField()
    {
        return request()->get('sorting_field', CollectionTextImageList::getIdProperty());
    }

}