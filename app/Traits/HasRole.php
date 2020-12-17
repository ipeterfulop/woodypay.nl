<?php


namespace App\Traits;


use App\Models\Role;

trait HasRole
{
    public function scopeAdmins($query)
    {
        return $query->whereIn('role_id', Role::where('is_admin', '=', 1)->get()->pluck('id')->all());
    }

    public function scopeNonAdmins($query)
    {
        return $query->whereNotIn('role_id', Role::where('is_admin', '=', 1)->get()->pluck('id')->all());
    }
}