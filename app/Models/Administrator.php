<?php


namespace App\Models;


use Illuminate\Database\Eloquent\Builder;

class Administrator extends User
{
    const SUBJECT_SLUG = 'administrator';
    const SUBJECT_NAME = 'Adminisztrátor';
    const SUBJECT_NAME_PLURAL = 'Adminisztrátorok';

    protected $table = 'users';

    protected static function booted()
    {
        static::addGlobalScope('admins', function(Builder $builder) {
            $builder->where('role_id', '=', Role::ADMIN_ID);
        });
    }

    public static function create(array $attributes = [])
    {
        $attributes['email_verified_at'] = now();
        $attributes['role_id'] = Role::ADMIN_ID;

        return static::query()->create($attributes);
    }


    public function getHomeUrl()
    {
        return '/admin';
    }
}