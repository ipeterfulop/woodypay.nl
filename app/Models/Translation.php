<?php

namespace App\Models;

use Datalytix\Translations\ITranslation;

class Translation extends \Datalytix\Translations\Translation implements ITranslation
{
    protected $fillable = [
        'id',
        'subject_id',
        'translationsubjecttype_id',
        'locale_id',
        'translation',
        'key',
        'field'
    ];

    public function loadTranslations($locale, $filterData = null)
    {
        return self::where('locale_id', '=', $locale)
            ->orderBy('translation', 'asc')
            ->when($filterData !== null, function ($query) use ($filterData) {
                if ($filterData != -1) {
                    if ($filterData == 0) {
                        return $query->where('translationsubjecttype_id', '=', null);
                    }

                    return $query->where('translationsubjecttype_id', '=', $filterData);
                } else {
                    return $query;
                }
            })
            ->get()
            ->mapWithKeys(function ($item) {
                return [$item->key => $item->translation];
            })->all();
    }

    public function getTranslationsForEditor($locales, $filterData = null)
    {
        $result = [];
        foreach ($locales as $locale) {
            $translations = $this->loadTranslations($locale, $filterData);
            foreach ($translations as $key => $translation) {
                if (!isset($result[$key])) {
                    $result[$key] = [];
                }
                $result[$key][$locale] = $translation;
            }
        }

        return $result;
    }

    public function storeTranslation($key, $locale, $translation)
    {
        $subjectId = null;
        $subjecttypeId = null;
        if (preg_match('/^\d{1,2}.\d{1,}$/', $key) == 1) {
            $parts = explode('-', $key);
            $subjectId = $parts[1];
            $subjecttypeId = $parts[0];
        }
        self::updateOrCreate([
            'key'       => $key,
            'locale_id' => $locale,
            'subject_id' => $subjectId,
            'translationsubjecttype_id' => $subjecttypeId
        ], [
            'key'         => $key,
            'locale_id'   => $locale,
            'translation' => (string) $translation,
        ]);

        $this->reloadTranslations($locale);

        return 'OK';
    }

    public function getCachedJSONTranslations($locale)
    {
        return \Cache::rememberForever($this->getCacheKey($locale), function () use ($locale) {
            return base64_encode(json_encode($this->loadTranslations($locale, 0), JSON_HEX_QUOT + JSON_HEX_APOS));
        });
    }

    public function scopeForModel($query, $model, $localeId = null)
    {
        return $query->where('translationsubjecttype_id', '=', $model::getSubjecttypeId())
            ->when(!is_null($localeId), function($query) use ($localeId) {
                return $query->where('locale_id', '=', $localeId);
            });
    }

}
