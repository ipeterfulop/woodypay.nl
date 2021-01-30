<?php

namespace App\Http\Controllers;

use App\Models\Attribute;
use App\Models\Locale;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AttributegroupsController extends Controller
{
    public function operations()
    {
        $method = request()->get('action', 'die');
        if (!method_exists($this, $method)) {
            abort(404);
        }

        return $this->$method();
    }

    protected function fetchData()
    {
        $attributes = Attribute::forGroup(request()->get('attributegroupId'))
            ->with(['attributevalue', 'attribute_value_set'])
            ->orderBy('label', 'asc')
            ->get();

        return response()->json([
            'attributes' => $attributes,
            'locales' => Locale::all(),
        ]);
    }

    protected function saveChanges()
    {
        $allLocales = Locale::all()->map(function($locale) {
            return ['id' => '_'.$locale->id, 'main' => $locale->is_main_locale == 1];
        });
        foreach (request()->get('attributes') as $attributeData) {
            $attribute = Attribute::with(['attributevalue', 'attribute_value_set'])->find($attributeData['id']);
            $locales = $attribute->is_translatable == 0
                ? [['id' => '', 'main' => true]]
                : $allLocales;

            if ($attribute->attribute_value_set_id == null) {
                $dataset = [];
                foreach($locales as $locale) {
                    $dataset['custom_value'.$locale['id']] = $attributeData['value'.$locale['id']];
                    if ($locale['main']) {
                        $dataset['custom_value'] = $attributeData['value'.$locale['id']];
                    }
                }
                $attribute->attributevalue->updateWithTranslations($dataset);
            } else {
                $attribute->attributevalue->update(['attribute_value_set_value_id' => $attribute['value']]);
            }
        }

        return response()->json([
            'message' => __('Settings updated')
        ]);
    }

    protected function storePublicPicture()
    {
        $filename = request()->get('fileName');
        \Storage::disk('public')->put(
            'attachments'.DIRECTORY_SEPARATOR.$filename,
            base64_decode(Str::after(request()->get('fileData'), ';base64,'))
        );
        return response()->json([
            'url' => asset('storage'
                .DIRECTORY_SEPARATOR
                .'attachments'
                .DIRECTORY_SEPARATOR
                .basename($filename)),
        ]);
    }

    protected function removePublicPicture()
    {
        return response('OK');
    }
}
