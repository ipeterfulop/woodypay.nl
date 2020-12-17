<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const ADMIN_ID = 1;
    const USER_ID = 2;

    protected $fillable = ['id', 'name', 'slug'];

    public function isAdmin()
    {
        return $this->is_admin == 1;
    }
}
