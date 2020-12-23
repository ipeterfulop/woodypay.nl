<?php

namespace App\Models;

use App\Formdatabuilders\BlockVueCRUDFormdatabuilder;
use App\Helpers\Visibility;
use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Indexfilters\SelectVueCRUDIndexfilter;
use Datalytix\VueCRUD\Traits\hasPosition;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use ReflectionClass;

class Block extends TranslatableModel
{
    use HasFactory, VueCRUDManageable, hasPosition;

    const SUBJECT_SLUG = 'block';
    const SUBJECT_NAME = 'Block';
    const SUBJECT_NAME_PLURAL = 'Blocks';

    protected $table = 'blocks';

    protected $fillable = [
        'blocktype_id',
        'layout',
        'text_color',
        'background_color',
        'background_gradient',
        'button_background_color',
        'button_text_color',
        'button_hover_background_color',
        'button_hover_text_color',
        'should_open_button_url_in_new_window',
    ];

    protected $with = ['blocktype'];

    protected $appends = [
        'block_type_label',
        'visibility_select',
        'items_link',
    ];

    const SUBJECTTYPE_ID = 1;

    public static function getSubjecttypeId()
    {
        return static::SUBJECTTYPE_ID;
    }

    public function block()
    {
        return $this->hasOne(Block::class, 'id', 'id');
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
        return $this->belongsTo(BlockType::class, 'blocktype_id');
    }

    public function getBlockTypeLabelAttribute()
    {
        return optional($this->blocktype)->name;
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'block_type_label'  => 'Type',
            'visibility_select' => 'Visibility',
            'items_link' => 'Items',
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
        $result['page_id']->setValueSet(Page::getKeyValueCollection()->all(), 0, 'Select page...');
        $result['page_id']->setContainerClass('hidden-important');
        return $result;
    }

    public static function modifyModellistButtons($buttons)
    {
        unset($buttons['details']);

        return $buttons;
    }

    public static function getRestrictingFields()
    {
        return ['page_id'];
    }

    public function scopeWithPosition($query)
    {
        return $query->select(
            $this->getTable() . '.*',
            \DB::raw('bp.position as position'),
            \DB::raw('bp.page_id as page_id'),
            \DB::raw('bp.visibility as visibility')
        )
                     ->leftJoinSub(BlockPage::query(), 'bp', 'bp.block_id', '=', $this->getTable() . '.id');
    }

    public static function getVueCRUDOptionalAjaxFunctions()
    {
        return [
            'storePublicPicture',
            'removePublicPicture',
        ];
    }


    public function getVisibilitySelectAttribute()
    {
        return 'component::' . json_encode(
                [
                    'component'      => 'ajax-select',
                    'componentProps' => [
                        'subject'     => $this->id,
                        'url'         => route('block_visibility_endpoint'),
                        'value'       => $this->visibility,
                        'action'      => 'update',
                        'componentId' => 'vis-' . $this->id,
                        'valueset'    => (object)Visibility::getKeyValueCollection()->all(),
                    ],
                ]
            );
    }

    public static function findDescendant($id)
    {
        $block = Block::find($id);
        $class = $block->blocktype->getClassNameFromTag(true);

        return $class::withAllTranslations()->find($block->id);
    }

    public function getBlockCSSName()
    {
        return 'bl-' . $this->id . '-';
    }

    public function getItemsLinkAttribute()
    {
        $descendant = self::findDescendant($this->id);
        if ($descendant instanceof IHasItemsContainer) {

            return '<a href="'.route($descendant::getItemsRouteName(), [
                $descendant::getItemsForeignKey() => $descendant->getItemsContainer()->id
            ]).'">'.__('Manage items').'</a>';
        } else {
            return '';
        }
    }

    public function getBlockPageForPageId($pageId)
    {
        return BlockPage::where('block_id', '=', $this->id)
                        ->where('page_id', '=', $pageId)
                        ->first();
    }

    public function exchangePositionWithElement($element)
    {
        if ($element === null) {
            return false;
        }
        $transactionResult = \DB::transaction(
            function () use ($element) {
                $elementBlockPage = BlockPage::where('page_id', '=', $element->page_id)
                                             ->where('block_id', '=', $element->id)
                                             ->first();
                $blockPage = BlockPage::where('page_id', '=', $element->page_id)
                                      ->where('block_id', '=', $this->id)
                                      ->first();
                $ePosition = $elementBlockPage->position;
                $elementBlockPage->update(['position' => $blockPage->position]);
                $blockPage->update(['position' => $ePosition]);
            }
        );

        return $transactionResult === null;
    }

    public function findPreviousElementByPosition()
    {
        $block = Block::withPosition()->find($this->id);
        return self::withPosition()->where($this->buildRestrictions())
                   ->where('position', '<', $block->position)
                   ->orderBy('position', 'desc')
                   ->first();
    }

    public function findNextElementByPosition()
    {
        $block = Block::withPosition()->find($this->id);
        return self::withPosition()->where($this->buildRestrictions())
                   ->where('position', '>', $block->position)
                   ->orderBy('position', 'desc')
                   ->first();
    }

    public function buildRestrictions()
    {
        $result = [];
        $block = self::withPosition()->find($this->id);
        foreach (self::getRestrictingFields() as $field) {
            $result[$field] = $block->$field;
        }

        return $result;
    }

}

