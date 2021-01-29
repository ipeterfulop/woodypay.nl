<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signup extends Model
{
    use HasFactory;

    protected $fillable = [
        'campaign',
        'locale',
        'firstname',
        'lastname',
        'email',
        'date_of_birth',
        'phone',
        'country_id',
        'city',
        'address',
        'postalcode',
        'referralcode',
        'spendingcategory_id',
        'would_use_card_as_primary',
        'most_attractive_feature_id',
        'custom_most_attractive_feature',
    ];
}
