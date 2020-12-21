<?php


namespace App\Dataproviders;


use App\Models\BlockPage;
use Datalytix\VueCRUD\Indexfilters\SelectVueCRUDIndexfilter;
use Illuminate\Database\Eloquent\Builder;

class BlockPageVueCRUDIndexfilter extends SelectVueCRUDIndexfilter
{
    public function __construct()
    {
        parent::__construct(
            'page_id',
            'Oldal',
            '-1',
        );
    }

    public function addFilterToQuery(Builder $query, $requestField = null)
    {
        if ($requestField != null) {
            $this->value = request()->get($requestField);
        }
        //return $query->whereIn('id', BlockPage::select('block_id'))
    }
}