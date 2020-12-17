<?php

namespace App\Dataproviders;

use App\Models\Useraction;
use Illuminate\Support\Collection;
use Datalytix\VueCRUD\Dataproviders\VueCRUDDataproviderBase;
use Datalytix\VueCRUD\Dataproviders\IVueCRUDDataprovider;

class UseractionVueCRUDDataprovider extends VueCRUDDataproviderBase implements IVueCRUDDataprovider
{

    function getBaseQuery()
    {
        return Useraction::query();
    }

    function getQuery()
    {
        $query = $this->getBaseQuery();
        $query = $this->addQueryFilters($query, Useraction::class);

        return $query;
    }

    protected function getSortingField()
    {
        return request()->get('sorting_field', Useraction::getIdProperty());
    }

}