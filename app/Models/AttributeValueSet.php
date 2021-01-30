<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValueSet extends TranslatableModel
{
    use HasFactory;

    const SUBJECTTYPE_ID = 103;

    protected $table = 'attribute_value_sets';
    protected $fillable = [
        'id',
        'name',
        'is_enabled',
        'created_at',
        'updated_at',
    ];

    protected $with = ['attribute_values'];

    public function attribute_values()
    {
        return $this->hasMany(AttributeValueSetValue::class);
    }

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['name'];
    }
}
