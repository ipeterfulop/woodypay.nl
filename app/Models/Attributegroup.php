<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attributegroup extends TranslatableModel
{
    use HasFactory, VueCRUDManageable;
    const SUBJECT_SLUG = 'attributegroup';
    const SUBJECT_NAME = 'Setting group';
    const SUBJECT_NAME_PLURAL = 'Setting groups';

    const SUBJECTTYPE_ID = 102;

    protected $fillable = [
        'id',
        'name',
        'variable_name',
        'created_at',
        'updated_at',
    ];

    public function attributes()
    {
        return $this->hasMany(Attribute::class);
    }

    protected $appends = ['settings'];

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public function getSettingsAttribute()
    {
        return 'component::' . json_encode(
                [
                    'component'      => 'attributes-popup-button',
                    'componentProps' => [
                        'operationsUrl' => route('attributegroups_endpoint'),
                        'attributegroupId'     => $this->id,
                        'windowTitle' => __($this->name).' '.__('settings')
                    ],
                ]
            );

    }

    public static function getTranslatedProperties(): array
    {
        return ['name'];
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'name' => __('Name'),
            'settings' => __('Configure'),
        ];
    }

    public static function getVueCRUDSortingIndexColumns()
    {
        return [];
    }

    public function getVueCRUDDetailsFields()
    {
        return [];
    }

    public static function getVueCRUDIndexFilters()
    {
        return [];
    }

    public static function shouldVueCRUDOperationsBeDisplayed()
    {
        return false;
    }

    public static function shouldVueCRUDAddButtonBeDisplayed()
    {
        return false;
    }
}
