<?php

namespace App\Models;

use App\Helpers\Visibility;
use App\Helpers\Widthtype;
use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Indexfilters\SelectVueCRUDIndexfilter;
use Datalytix\VueCRUD\Indexfilters\TextVueCRUDIndexfilter;
use Datalytix\VueCRUD\Traits\HasPositionThroughPivot;
use Datalytix\VueCRUD\Traits\VueCRUDManageable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use ReflectionClass;

class Block extends TranslatableModel
{
    use HasFactory, VueCRUDManageable, HasPositionThroughPivot;

    const SUBJECT_SLUG = 'block';
    const SUBJECT_NAME = 'Block';
    const SUBJECT_NAME_PLURAL = 'Blocks';

    protected $table = 'blocks';

    protected $fillable = [
        'blocktype_id',
        'layout',
        'title',
        'content',
        'text_color',
        'background_color',
        'background_gradient',
        'button_label',
        'button_url',
        'button_background_color',
        'button_text_color',
        'button_hover_background_color',
        'button_hover_text_color',
        'should_open_button_url_in_new_window',
        'internal_name',
        'widthtype',
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
        return [
            'title',
            'content',
            'button_label',
            'button_url',
        ];
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
        return optional($this->blocktype)->name_translated;
    }

    public static function getVueCRUDIndexColumns()
    {
        return [
            'block_type_label'  => 'Type',
            'internal_name'  => 'Internal name',
            'visibility_select' => 'Visibility',
            'items_link'        => 'Items',
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
        $result['internal_name'] = new TextVueCRUDIndexfilter('internal_name', 'Name', '');
        $result['page_id'] = new SelectVueCRUDIndexfilter('page_id', 'Page', request()->get('page_id', 0));
        $result['page_id']->setValueSet(Page::getKeyValueCollection()->all(), 0, 'Select page...');
        $result['page_id']->setContainerClass('hidden-important');
        return $result;
    }

    public static function modifyModellistButtons($buttons)
    {
        unset($buttons['details']);
        $buttons['copy'] = [
            'class' => 'btn',
            'html' => config('heroicons.solid.clipboard-copy'),
            'componentName' => 'copyBlockComponent',
            'props' => ['pages' => Page::all(), 'operationsUrl' => route('copy_block_endpoint')]
        ];
        return $buttons;
    }

    public static function getRestrictingFields()
    {
        return ['page_id'];
    }

//    public function scopeWithPosition($query)
//    {
//        return $query->select(
//            $this->getTable() . '.*',
//            \DB::raw('bp.position as position'),
//            \DB::raw('bp.page_id as page_id'),
//            \DB::raw('bp.visibility as visibility')
//        )
//                     ->leftJoinSub(BlockPage::query(), 'bp', 'bp.block_id', '=', $this->getTable() . '.id');
//    }
//
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
        if (method_exists($descendant, 'getItemsLink')) {
            return $descendant->getItemsLink();
        }
        if ($descendant instanceof IHasItemsContainer) {
            return '<a href="' . route(
                    $descendant::getItemsRouteName(),
                    [
                        $descendant::getItemsForeignKey() => $descendant->getItemsContainer()->id,
                        'referer'                         => static::getVueCRUDBackreferenceParameterValue(['page_id']),
                    ]
                ) . '">' . __('Manage items') . '</a>';
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

    public function getLayoutName()
    {
        if ($this->blocktype->layout_class == null) {
            return $this->blocktype_id;
        }
        return $this->layout;
    }

    public static function getPositioningPivotForeignKey()
    {
        return 'block_id';
    }

    public static function getPositioningPivotModelclass()
    {
        return BlockPage::class;
    }

    public static function getPositioningPivotModelFields()
    {
        return ['position', 'page_id', 'visibility'];
    }

    public static function getVueCRUDParentIndexLink()
    {
        if (request()->has('page_id')) {
            return [
                'url'   => route('vuecrud_page_index'),
                'label' => __('Back to') . ' ' . mb_strtolower(__('Pages')),
            ];
        }

        return null;
    }

    public function copyToPage($page_id, $visibility = Visibility::ADMIN_ID)
    {
        BlockPage::firstOrCreate([
            'page_id' => $page_id,
            'block_id' => $this->id,
            'position' => BlockPage::getFirstAvailablePosition(['page_id' => $page_id]),
            'visibility' => $visibility,
        ]);
    }

    public static function filterDataForPivotModelRestrictions($data)
    {
        return ['page_id' => $data['page_id']];
    }
}

