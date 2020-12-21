<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Indexfilters\SelectVueCRUDIndexfilter;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Block extends TranslatableModel
{
    use HasFactory, VueCRUDManageable;
    const SUBJECT_SLUG = 'block';
    const SUBJECT_NAME = 'Block';
    const SUBJECT_NAME_PLURAL = 'Blocks';

    protected $fillable = ['blocktype_id'];

    protected $with = ['blocktype'];

    protected $appends = ['block_type_label'];

    const SUBJECTTYPE_ID = 1;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public static function getTranslatedProperties(): array
    {
        return [];
    }

    public static function getBlockTypeTag(): ?string
    {
        $reflect = new ReflectionClass(new static());
        return 'tag_' . $reflect->getShortName();
    }

    public function blocktype()
    {
        return $this->belongsTo(BlockType::class);
    }

    public static function createWithTranslations($data)
    {
        $model = null;
        \DB::transaction(function() use ($data, &$model){
            $typeId = BlockType::findByTag(static::getBlockTypeTag())->id;
            $block = Block::create([
                'blocktype_id' => $typeId
            ]);
            $data['id'] = $block->id;
            $model = parent::createWithTranslations($data);
        });

        return $model;
    }

    public function getBlockTypeLabelAttribute()
    {
        return $this->blocktype->name;
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'block_type_label' => 'Type'
        ];
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
        $result = [];
        $result['page_id'] = new SelectVueCRUDIndexfilter('page_id', 'Page', 0);
        $result['page_id']->setValueSet(Page::all()->pluck('name', 'id')->all(), 0, 'Select page...');

        return $result;
    }

    public static function modifyModellistButtons($buttons)
    {
        unset($buttons['details']);

        return $buttons;
    }

    public function scopeWithPosition($query)
    {
        return $query->select('blocks.*', \DB::raw('bp.position as position'), \DB::raw('bp.page_id as page_id'))
            ->leftJoinSub(BlockPage::query(), 'bp', 'bp.block_id', '=', 'blocks.id');
    }
}

