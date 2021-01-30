<?php

namespace App\Dataproviders;

use App\Models\Attributegroup;
use Illuminate\Support\Collection;
use Datalytix\VueCRUD\Dataproviders\VueCRUDDataproviderBase;
use Datalytix\VueCRUD\Dataproviders\IVueCRUDDataprovider;

class AttributegroupVueCRUDDataprovider extends VueCRUDDataproviderBase implements IVueCRUDDataprovider
{

    function getBaseQuery()
    {
        return Attributegroup::query();
    }

    function getQuery()
    {
        $query = $this->getBaseQuery();
        $query = $this->addQueryFilters($query, Attributegroup::class);

        return $query;
    }

    protected function getSortingField()
    {
        return request()->get('sorting_field', Attributegroup::getIdProperty());
    }

}