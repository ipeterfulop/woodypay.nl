<?php

namespace App\Dataproviders;

use App\Models\TextImageItem;
use Illuminate\Support\Collection;
use Datalytix\VueCRUD\Dataproviders\VueCRUDDataproviderBase;
use Datalytix\VueCRUD\Dataproviders\IVueCRUDDataprovider;

class TextImageItemVueCRUDDataprovider extends VueCRUDDataproviderBase implements IVueCRUDDataprovider
{

    function getBaseQuery()
    {
        return TextImageItem::withAllTranslations();
    }

    function getQuery()
    {
        $query = $this->getBaseQuery();
        $query = $this->addQueryFilters($query, TextImageItem::class);

        return $query;
    }

    protected function getSortingField()
    {
        return request()->get('sorting_field', TextImageItem::getIdProperty());
    }

}