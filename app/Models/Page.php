<?php

namespace App\Models;

use App\Helpers\Visibility;
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
        'blocks_label',
    ];

    public function getVuecrudDeleteAllowedAttribute()
    {
        return $this->tag == null;
    }

    public function getBlocksLabelAttribute()
    {
        return '<a href="'.route('vuecrud_block_index', ['page_id' => $this->id]).'">'
            .__('Manage blocks')
            .'</a>';
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
            'name' => __('Name'),
            'urls_label' => __('URLs'),
            'blocks_label' => __('Manage blocks'),
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

    public static function getKeyValueCollection()
    {
        return self::all()->pluck('name', 'id');
    }

    public function getBlocks()
    {
        $result = [];
        $visibility = \Auth::check() && \Auth::user()->isAdmin()
            ? Visibility::ADMIN_ID
            : Visibility::EVERYONE_ID;
        foreach (Block::where('page_id', '=', $this->id)->orderBy('position', 'asc')->get() as $block) {
            if ($block->visibility >= $visibility) {
                $result[] = Block::findDescendant($block->id);
            }
        }

        return collect($result);
    }
}
