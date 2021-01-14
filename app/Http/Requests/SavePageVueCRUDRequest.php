<?php

namespace App\Http\Requests;

use App\Formdatabuilders\PageVueCRUDFormdatabuilder;
use App\Models\Locale;
use App\Models\Page;
use App\Rules\PageUrlUnique;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SavePageVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = PageVueCRUDFormdatabuilder::class;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $class = static::FORMDATABUILDER_CLASS;
        $result = $class::getValidationRules($this->getRequestType());
        foreach(Locale::all() as $locale) {
            if (!isset($result[$locale->getTranslatedPropertyName('url')])) {
                $result[$locale->getTranslatedPropertyName('url')] = [];
            }
            $result[$locale->getTranslatedPropertyName('url')][] = new PageUrlUnique($this->getRequestSubjectId());
        }

        return $result;
    }

    public function save(Page $subject = null)
    {
        $dataset = $this->getDataset();
        if ($subject == null) {
            $subject = Page::createWithTranslations($dataset);
        } else {
            $subject->updateWithTranslations($dataset);
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = [];
        $mainLocale = Locale::getMainLocale();
        foreach(Locale::all() as $locale) {
            $result[$locale->getTranslatedPropertyName('name')] = $this->input($locale->getTranslatedPropertyName('name'));
            $result[$locale->getTranslatedPropertyName('url')] = $this->input($locale->getTranslatedPropertyName('url'));
            if ($locale->id == $mainLocale->id) {
                $result['name'] = $this->input($locale->getTranslatedPropertyName('name'));
                $result['url'] = $this->input($locale->getTranslatedPropertyName('url'));
            }
        }
        return $result;
    }
}
