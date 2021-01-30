<?php


namespace App\Helpers;


use App\Models\Attributegroup;

class SiteSettingsFactory
{
    public static function getSiteSettings()
    {
        $result = [];
        $groups = AttributeGroup::with([
            'attributes',
            'attributes.attribute_value_set',
            'attributes.attributevalue',
        ])->get();
        foreach ($groups as $group) {
            foreach ($group->attributes as $attribute) {
                $result[$group->variable_name.'.'.$attribute->name] = $attribute->actual_value;
            }
        }

        return $result;
    }
}