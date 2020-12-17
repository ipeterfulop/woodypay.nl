<?php

namespace App\Dataproviders;

use App\Models\Administrator;
use Illuminate\Support\Collection;
use Datalytix\VueCRUD\Dataproviders\VueCRUDDataproviderBase;
use Datalytix\VueCRUD\Dataproviders\IVueCRUDDataprovider;

class AdministratorVueCRUDDataprovider extends VueCRUDDataproviderBase implements IVueCRUDDataprovider
{

    function getBaseQuery()
    {
        return Administrator::query();
    }

    function getQuery()
    {
        $query = $this->getBaseQuery();
        $query = $this->addQueryFilters($query, Administrator::class);

        return $query;
    }

    protected function getSortingField()
    {
        return request()->get('sorting_field', Administrator::getIdProperty());
    }

}