<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attribute extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'attribute_value_set_id',
        'attributegroup_id',
        'name',
        'label',
        'created_at',
        'updated_at',
        'is_translatable'
    ];

    public function attributevalue()
    {
        return $this->hasOne(AttributeValue::class)->withAllTranslations();
    }

    public function attribute_value_set()
    {
        return $this->belongsTo(AttributeValueSet::class);
    }

    public function getActualValueAttribute()
    {
        if ($this->attributevalue->attribute_value_set_value_id != null) {
            return $this->attributevalue->attributevaluesetvalue->value;
        }

        return $this->is_translatable
            ? $this->attributevalue->custom_value_translated
            : $this->attributevalue->custom_value;

    }

    /**
     * @param string $variablename
     * @return Attribute|null
     */
    public static function findByVariableName(string $variablename): ?Attribute
    {
        return Attribute::where('variable_name', $variablename)
                        ->get()
                        ->first();
    }

    public function takesValueFromSet(): bool
    {
        return !is_null($this->attribute_value_set_id);
    }

    public function hasValueInSet($value): bool
    {
        if (!$this->takesValueFromSet()) {
            return false;
        }

        return !is_null(self::getAttributeValueFromSetByValue($value));
    }

    public function hasLabelInSet($label): bool
    {
        if (!$this->takesValueFromSet()) {
            return false;
        }

        return !is_null(self::getAttributeValueFromSetByLabel($label));
    }

    public function getAttributeValueFromSetByValue($value)
    {
        return AttributeValueSetValue::where('attribute_value_set_id', $this->attribute_value_set_id)
                                     ->where('value', $value)
                                     ->get()
                                     ->first();
    }

    public function getAttributeValueFromSetByLabel($label)
    {
        return AttributeValueSetValue::where('attribute_value_set_id', $this->attribute_value_set_id)
                                     ->where('label', $label)
                                     ->get()
                                     ->first();
    }

    public function scopeForGroup($query, $attributegroupId)
    {
        return $query->where('attributegroup_id', '=', $attributegroupId);
    }

}
