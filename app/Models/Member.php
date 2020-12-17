<?php

namespace App\Models;

use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends User
{
    use VueCRUDManageable;
    const SUBJECT_SLUG = 'member';
    const SUBJECT_NAME = 'Felhasználó';
    const SUBJECT_NAME_PLURAL = 'Felhasználók';

    protected $table = 'users';

    protected static function booted()
    {
        static::addGlobalScope('admins', function(Builder $builder) {
            $builder->where('role_id', '=', Role::USER_ID);
        });
    }

    public static function create(array $attributes = [])
    {
        $attributes['role_id'] = Role::USER_ID;

        return static::query()->create($attributes);
    }
}
