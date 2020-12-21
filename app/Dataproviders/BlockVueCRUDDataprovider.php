<?php

namespace App\Dataproviders;

use App\Models\Block;
use Illuminate\Support\Collection;
use Datalytix\VueCRUD\Dataproviders\VueCRUDDataproviderBase;
use Datalytix\VueCRUD\Dataproviders\IVueCRUDDataprovider;

class BlockVueCRUDDataprovider extends VueCRUDDataproviderBase implements IVueCRUDDataprovider
{

    function getBaseQuery()
    {
        return Block::withPosition();
    }

    function getQuery()
    {
        $query = $this->getBaseQuery();
        $query = $this->addQueryFilters($query, Block::class);

        return $query;
    }

    protected function getSortingField()
    {
        return request()->get('sorting_field', Block::getIdProperty());
    }

}