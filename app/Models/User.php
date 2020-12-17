<?php

namespace App\Models;

use App\Traits\HasDisabledTimestamp;
use App\Traits\HasRole;
use Datalytix\VueCRUD\Indexfilters\TextVueCRUDIndexfilter;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use App\Notifications\ResetPassword as ResetPasswordNotification;
use App\Notifications\VerifyEmail;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements \Illuminate\Contracts\Auth\MustVerifyEmail
{
    use HasFactory, Notifiable, VueCRUDManageable, MustVerifyEmail, HasDisabledTimestamp, HasRole;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role_id',
        'email_verified_at',
        'disabled_at',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'disabled_at' => 'datetime',
    ];

    protected $with = [
        'role'
    ];

    protected $appends = [
        'name_and_email'
    ];

    public function getNameAndEmailAttribute()
    {
        return $this->name.' ('.$this->email.')';
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function isAdmin()
    {
        return $this->role->isAdmin();
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'name' => __('Név'),
            'email' => __('E-mail')
        ];
    }

    public static function getVueCRUDSortingIndexColumns()
    {
        return [
            'name' => 'name',
            'email' => 'email',
        ];
    }

    public function getVueCRUDDetailsFields()
    {
        return [
            'name' => __('Név'),
            'email' => __('E-mail'),
            'created_at' => __('Létrehozva')
        ];
    }

    public static function getVueCRUDIndexFilters()
    {
        $result = [];
        $fields = ['name', 'email'];
        $result[TextVueCRUDIndexfilter::buildPropertyName($fields)] = new TextVueCRUDIndexfilter($fields, __('Keresés'), '', '');

        return $result;
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Send the email verification notification.
     *
     * @return void
     */
    public function sendEmailVerificationNotification()
    {
        $this->notify(new VerifyEmail);
    }

    public function getHomeUrl()
    {
        if ($this->role->isAdmin()) {
            return '/admin';
        }

        return '/';
    }
}
