<?php

namespace App\Dataproviders;

use App\Models\Page;
use Illuminate\Support\Collection;
use Datalytix\VueCRUD\Dataproviders\VueCRUDDataproviderBase;
use Datalytix\VueCRUD\Dataproviders\IVueCRUDDataprovider;

class PageVueCRUDDataprovider extends VueCRUDDataproviderBase implements IVueCRUDDataprovider
{

    function getBaseQuery()
    {
        return Page::withAllTranslations();
    }

    function getQuery()
    {
        $query = $this->getBaseQuery();
        $query = $this->addQueryFilters($query, Page::class);

        return $query;
    }

    protected function getSortingField()
    {
        return request()->get('sorting_field', Page::getIdProperty());
    }

}