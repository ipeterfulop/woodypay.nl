<?php

namespace App\Models;

use Datalytix\Translations\TranslatableModel;
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

    }

    public static function modifyModellistButtons($buttons)
    {
        unset($buttons['details']);

        return $buttons;
    }
}

