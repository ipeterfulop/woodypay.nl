<?php

namespace App\Models;

use Datalytix\Translations\Traits\LocaleFunctions;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Model;

class Locale extends Model
{
    use VueCRUDManageable, LocaleFunctions;
    const LABEL_FIELD = 'name';
    const USE_LABEL_AS_TRANSLATION_KEY = true;
    const SUBJECT_SLUG = 'locale';
    const SUBJECT_NAME = 'Nyelv';
    const SUBJECT_NAME_PLURAL = 'Nyelvek';

    public $incrementing = false;

    protected $fillable = [
        'id',
        'name',
        'is_main',
        'deactivated_at',
        'decimal_separator',
    ];

    protected $appends = [
        'is_main_label'
    ];

    public static function getVueCRUDIndexColumns()
    {
        return [
            'id' => 'Kód',
            'name' => 'Név',
        ];
    }

    public static function getVueCRUDSortingIndexColumns()
    {
        return [
            'Kód' => 'id',
            'Név' => 'name',
        ];
    }

    public function getVueCRUDDetailsFields()
    {
        return [
            'id' => 'Kód',
            'name' => 'Név',
            'is_main_label' => 'Alapértelmezett',
            'decimal_separator' => 'Tizedesjelző'
        ];
    }

    public static function getVueCRUDIndexFilters()
    {
        return [];
    }

    public static function all($columns = ['*'])
    {
        return static::query()->orderBy('is_main', 'desc')->orderBy('id', 'asc')->get(
            is_array($columns) ? $columns : func_get_args()
        );
    }

    public static function localeRoute($routeName, $locale = null, $parameters = [], $absolute = true)
    {
        return route($routeName, ['locale' => $locale ?? \App::getLocale()] + $parameters, $absolute);
    }

    public static function setValidatedLocale($locale)
    {
        $locale = self::find($locale);

        if ($locale === null) {
            \App::setLocale('hu');
        } else {
            \App::setLocale($locale->id);
        }
        if (\Auth::check()) {
            \Auth::user()->update(['locale_id' => $locale === null ? 'hu' : $locale->id]);
        }
        return;
    }

    public static function getKeyValueCollection()
    {
        return static::all()->pluck('id', 'id');
    }
}
