<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends TranslatableModel
{
    use HasFactory;

    protected $fillable = [
        'attribute_id',
        'attribute_value_set_value_id',
        'custom_value'
    ];

    protected $with = ['attributevaluesetvalue'];

    public function attributevaluesetvalue()
    {
        return $this->hasOne(AttributeValueSetValue::class, 'id', 'attribute_value_set_value_id');
    }

    const SUBJECTTYPE_ID = 103;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return ['custom_value'];
    }
}
