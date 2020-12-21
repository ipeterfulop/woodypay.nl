<?php


namespace App\Helpers;


use App\Formdatabuilders\BlockVueCRUDFormdatabuilder;
use App\Models\Block;
use App\Models\BlockPage;
use App\Models\BlockType;
use Illuminate\Database\Eloquent\Builder;

abstract class DescendantBlock extends Block
{
    protected static function booted()
    {
        static::addGlobalScope('withparentdata', function(Builder $builder) {
            $fields = collect((new Block())->getFillable())->except(['id', 'created_at', 'updated_at'])->transform(function($field) {
                return 'bb.'.$field;
            })->all();
            return $builder->select()->addSelect($fields)->leftJoinSub(
                Block::query(),
                'bb',
                'bb.id',
                '=',
                (new static())->getTable().'.id'
            );
        });

        parent::booted();
    }

    public function remove()
    {
        return \DB::transaction(function() {
            //$blockPages = BlockPage::where('block_id', '=', $this->id)->get();
            //$position = BlockPage::where('')
            BlockPage::where('block_id', '=', $this->id)->delete();
            $parentblock = Block::find($this->id);
            $translationClass = config('app.translationClass');
            $translationClass::forModel($this)
                ->where('subject_id', '=', $this->id)
                ->delete();
            $translationClass::forModel($parentblock)
                ->where('subject_id', '=', $this->id)
                ->delete();
            $this->delete();
            $parentblock->delete();
        }) === null;
    }

    public static function createWithTranslations($data)
    {
        $model = null;
        \DB::transaction(function() use ($data, &$model){
            $typeId = BlockType::findByTag(static::getBlockTypeTag())->id;
            $blockData = collect($data)->only((new Block())->getFillable())->except(['id'])->all();
            $blockData['blocktype_id'] = $typeId;
            $subData = collect($data)->except(array_keys($blockData))->all();
            $block = Block::create($blockData);
            $subData['id'] = $block->id;
            $model = parent::createWithTranslations($subData);
        });

        return $model;
    }

    public function updateWithTranslations($data)
    {
        return \DB::transaction(function() use ($data){
            $blockData = collect($data)->only((new Block())->getFillable())->except(['id', 'blocktype_id'])->all();
            \DB::table('blocks')->where('id', '=', $this->id)->update($blockData);
            $subData = collect($data)->except(array_keys($blockData))->except(['id', 'page_id', 'blocktype_id'])->all();
            parent::updateWithTranslations($subData);
        }) === null;
    }

    public static function getVueCRUDFormdatabuilderClassname()
    {
        return BlockVueCRUDFormdatabuilder::class;
    }

    public function scopeWithPosition($query)
    {
        return $query->select($this->getTable().'.*', \DB::raw('bp.position as position'), \DB::raw('bp.page_id as page_id'))
            ->leftJoinSub(BlockPage::query(), 'bp', 'bp.block_id', '=', $this->getTable().'.id');
    }

}