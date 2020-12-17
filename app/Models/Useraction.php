<?php

namespace App\Models;

use App\Helpers\UseractionType;
use Datalytix\VueCRUD\Indexfilters\SearchableSelectVueCRUDIndexFilter;
use Datalytix\VueCRUD\Indexfilters\SelectVueCRUDIndexfilter;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Useraction extends Model
{
    use HasFactory, VueCRUDManageable;

    const SUBJECT_SLUG = 'useraction';
    const SUBJECT_NAME = 'Felhasználói aktivitás';
    const SUBJECT_NAME_PLURAL = 'Felhasználói aktivitások';

    protected $fillable = [
        'user_id',
        'actiontype_id',
        'comment'
    ];

    protected $with = 'user';

    protected $appends = [
        'username',
        'useremail',
        'timestamp_label',
        'actiontype_label'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUsernameAttribute()
    {
        return $this->user->name;
    }

    public function getUseremailAttribute()
    {
        return $this->user->email;
    }

    public function getTimestampLabelAttribute()
    {
        return $this->created_at->format('Y-m-d H:i:s');
    }

    public function getActiontypeLabelAttribute()
    {
        return UseractionType::getLabelForId($this->actiontype_id);
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'useremail' => __('E-mail'),
            'timestamp_label' => __('Időpont'),
            'actiontype_label' => __('Művelet')
        ];
    }

    public static function getVueCRUDSortingIndexColumns()
    {
        return [
            'timestamp_label' => 'created_at',
            'actiontype_label' => 'actiontype_id',
        ];
    }

    public function getVueCRUDDetailsFields()
    {
        return [
            'username' => __('Név'),
            'useremail' => __('E-mail'),
            'timestamp_label' => __('Időpont'),
            'actiontype_label' => __('Művelet')
        ];
    }

    public static function getVueCRUDIndexFilters()
    {
        $result = [];
        $result['user_id'] = new SearchableSelectVueCRUDIndexFilter('user_id', 'Felhasználó', -1);
        $result['user_id']->setValueset(User::orderBy('name')->get());
        $result['user_id']->props['labelProperty'] = 'name_and_email';
        //$result['startdate'] =

        return $result;
    }

    public static function shouldVueCRUDAddButtonBeDisplayed()
    {
        return false;
    }

    public static function shouldVueCRUDOperationsBeDisplayed()
    {
        return false;
    }
}
