<?php

namespace App\Dataproviders;

use App\Models\TextImageList;
use Illuminate\Support\Collection;
use Datalytix\VueCRUD\Dataproviders\VueCRUDDataproviderBase;
use Datalytix\VueCRUD\Dataproviders\IVueCRUDDataprovider;

class TextImageListVueCRUDDataprovider extends VueCRUDDataproviderBase implements IVueCRUDDataprovider
{

    function getBaseQuery()
    {
        return TextImageList::query();
    }

    function getQuery()
    {
        $query = $this->getBaseQuery();
        $query = $this->addQueryFilters($query, TextImageList::class);

        return $query;
    }

    protected function getSortingField()
    {
        return request()->get('sorting_field', TextImageList::getIdProperty());
    }

}