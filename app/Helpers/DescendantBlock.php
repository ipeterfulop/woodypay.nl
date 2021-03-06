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
            $blockfields = collect((new Block())->getFillable())->except(['id', 'created_at', 'updated_at']);
            $fields = $blockfields->map(function($field) {
                return 'bb.'.$field;
            })->all();
            $blockfields->push('id');
            return $builder->select()->addSelect($fields)->leftJoinSub(
                Block::select($blockfields->all()),
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
            $translationClass = config('app.translationClass');
            $translationClass::forModel($this)
                ->where('subject_id', '=', $this->id)
                ->delete();
            if (method_exists($this, 'deleteItemsContainer')) {
                $this->deleteItemsContainer();
            }
            $this->updatePositionOfOtherElementsBeforeDelete();
            $this->delete();
            \DB::table('blocks')->where('id', '=', $this->id)->delete();
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

    public static function getBaseQuery()
    {
        return Block::query();
    }
}