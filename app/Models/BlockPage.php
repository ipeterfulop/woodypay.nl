<?php

namespace App\Models;

use Datalytix\VueCRUD\Traits\hasPosition;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlockPage extends Model
{
    use HasFactory, hasPosition;

    protected $table = 'block_page';

    protected $fillable = ['page_id', 'block_id', 'position'];

    /**
     * @return array
     * this function returns a list of fields that are used as restrictions when changing position
     * for example if it returns ['role_id'], every non-static positioning function will
     * only look for elements with the same role_id as the subject
     */
    public static function getRestrictingFields()
    {
        return ['page_id'];
    }
}
