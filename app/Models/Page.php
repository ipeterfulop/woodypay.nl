<?php

namespace App\Models;

use App\Http\Controllers\PagesController;
use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Page extends TranslatableModel
{
    use HasFactory, VueCRUDManageable;
    const SUBJECT_SLUG = 'page';
    const SUBJECT_NAME = 'Page';
    const SUBJECT_NAME_PLURAL = 'Pages';

    const SUBJECTTYPE_ID = 2;

    protected $fillable = [
        'tag',
    ];

    protected $appends = [
        'urls_label',
        'vuecrud_delete_allowed',
    ];

    public function getVuecrudDeleteAllowedAttribute()
    {
        return $this->tag == null;
    }

    public function blocks()
    {
        return $this->hasManyThrough(
            Block::class,
            BlockPage::class,
            'block_id',
            'id',
            'id',
            'page_id'
        );
    }

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public function findByTag($tag)
    {
        return self::whereTag($tag)->first();
    }

    public static function getTranslatedProperties(): array
    {
        return ['name', 'url'];
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'name' => 'Name',
            'urls_label' => 'URLs',
        ];
    }

    public function getUrlsLabelAttribute()
    {
        $result = [];
        foreach (Locale::all() as $locale) {
            $result[] = $this->getLocaleUrl($locale->id);
        }

        return implode('<br>', $result);
    }

    public static function getVueCRUDSortingIndexColumns()
    {
        return [];
    }

    public function getVueCRUDDetailsFields()
    {
        return [];
    }

    public static function getVueCRUDIndexFilters()
    {
        return [];
    }

    public static function setRoutes()
    {
        $pages = self::withAllTranslations()->get();
        foreach (Locale::all() as $locale) {
            foreach ($pages as $page) {
                \Route::get($page->getLocaleUrl($locale->id), [PagesController::class, 'resolve']);
            }
        }
    }

    public function getLocaleUrl(string $locale = null)
    {
        $locale = $locale ?? optional(Locale::find($locale))->id;
        if ($locale == null) {
            $locale = Locale::getMainLocale()->id;
        }
        $url = $url = \Str::startsWith($this->url, '/') ? $this->url : '/'.$this->url;

        return '/'.$locale.$url;
    }


}
