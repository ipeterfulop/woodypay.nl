<?php


namespace App\Formdatabuilders;


use App\BlockLayouts\TextImageListCollectionBlockLayout;
use App\BlockLayouts\TextImageListLayout;
use App\BlockStyledefinition;
use App\Helpers\BackgroundColorType;
use App\Helpers\Widthtype;
use App\Models\Block;
use App\Models\BlockType;
use App\Models\IHasItemsContainer;
use App\Models\Locale;
use App\Models\Page;
use App\Models\Positioning;
use App\Models\Spacing;
use App\Models\TextImageListCollectionBlock;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\ColorVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\ImagePickerVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\RichttextQuillVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\SelectVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\StaticVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\TextVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\YesNoSelectVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Valuesets\YesNoValueset;
use Datalytix\VueCRUD\Formdatabuilders\VueCRUDFormdatabuilder;

class BlockVueCRUDFormdatabuilder extends VueCRUDFormdatabuilder
{
    public static function getApplicationColorPresets()
    {
        return config('colors');
    }

    /**
     * @return Illuminate\Support\Collection;
     * returns a collection of VueCRUDFormfield descendants that
     * define what the edit/create forms will contain
     */
    protected static function getFields()
    {
        $result = [];
        $result['page_id'] = (new SelectVueCRUDFormfield())
            ->setLabel('Page')
            ->setMandatory(true)
            ->setContainerClass('col-12')
            ->setDefault(request()->get('page_id'))
            ->setOnlyWhenCreating(true)
            ->setValuesetClass(Page::class);

        $result['blocktype_id'] = (new SelectVueCRUDFormfield())
            ->setStep(1)
            ->setMandatory(true)
            ->setLabel('Block type')
            ->setValuesetClass(BlockType::class);
        $cache = [
            'locales' => Locale::all(),
        ];

        $result = static::addBaseBlockFields($result);
        foreach(BlockType::all() as $blockType) {
            $result = static::addFieldsBasedOnBlocktype($result, $blockType, $cache);
        }

        // reorder to move misc/content blocks to the top
        $newResult = [];
        $groups = [];
        foreach ($result as $key => $field) {
            if (!isset($groups[$field->getGroup()])) {
                $groups[$field->getGroup()] = [];
            }
            $groups[$field->getGroup()][] = $key;
        }
        foreach (['', 'Miscellaneous', 'Content', 'Formatting'] as $g) {
            foreach ($groups[$g] as $key) {
                $newResult[$key] = $result[$key];
            }
        }
        return collect($newResult);
    }

    protected static function addBaseBlockFields($result)
    {
        $result['internal_name'] = (new TextVueCRUDFormfield())
            ->setLabel('Internal name')
            ->setMandatory(true)
            ->setStep(2)
            ->setGroup(__('Miscellaneous'))
            ->setContainerClass('w-full');
        $result['widthtype'] = (new SelectVueCRUDFormfield())
            ->setLabel('Width')
            ->setMandatory(true)
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setValuesetClass(Widthtype::class)
            ->setDefault(Widthtype::CENTERED_ID)
            ->setContainerClass('w-full');
        $result['text_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Text color')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $result['backgroundtype'] = (new SelectVueCRUDFormfield())
            ->setLabel('Background color type')
            ->setContainerClass('w-full')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setValuesetClass(BackgroundColorType::class)
            ->setDefault(BackgroundColorType::SOLID_ID);
        $result['background_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Background color')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $result['second_background_color'] = (new ColorVueCRUDFormfield())
            ->setHideIf([
                ['$backgroundtype', '=', BackgroundColorType::SOLID_ID]
            ])
            ->setLabel('Second background color (for gradients)')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $result['should_open_button_url_in_new_window'] = (new YesNoSelectVueCRUDFormfield())
            ->setValuesetClass(YesNoValueset::class)
            ->setLabel('Open button URL in new window (if applicable)')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setDefault(0)
            ->setContainerClass('w-full');
        $result['button_background_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button background color')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/4')
            ->setPresets(static::getApplicationColorPresets());
        $result['button_text_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button text color')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/4')
            ->setPresets(static::getApplicationColorPresets());
        $result['button_hover_background_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button background color (hover)')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/4')
            ->setPresets(static::getApplicationColorPresets());
        $result['button_hover_text_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button text color (hover)')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/4')
            ->setPresets(static::getApplicationColorPresets());

        return $result;
    }

    protected static function addFieldsBasedOnBlocktype($result, BlockType $blockType, $cache)
    {
        $methodName = 'addFieldsFor'.$blockType->getClassNameFromTag();
        if (!method_exists(new self(), $methodName)) {
            throw new \Exception('Invalid formbuilder method: '.$methodName);
        }
        $fields = static::$methodName($cache);
        $prefix = $blockType->id.'_';
        foreach ($fields as $key => $field) {
            $result[$prefix.$key] = $field;
            $result[$prefix.$key]->setConditions([['field' => 'blocktype_id', 'value' => $blockType->id]]);
            $result[$prefix.$key]->setStep(2);
        }

        return $result;
    }

    protected static function addFieldsForHeroBlock($cache)
    {
        $fields = [];
        $fields['background_image'] = (new ImagePickerVueCRUDFormfield())
            ->setLabel('Background image')
            ->setGroup('Formatting')
            ->setContainerClass('w-full');
        $fields['background_image_positioning_id'] = (new SelectVueCRUDFormfield())
            ->setLabel('Background image positioning')
            ->setContainerClass('w-full')
            ->setGroup('Formatting')
            ->setValuesetClass(Positioning::class)
            ->setValuesetGetter('getBackgroundPositioningOptions');
        foreach ($cache['locales'] as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setGroup('Content')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setGroup('Content')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_label')] = (new TextVueCRUDFormfield())
                ->setLabel('Button label ('.$locale->uppercase_id.')')
                ->setGroup('Content')
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_url')] = (new TextVueCRUDFormfield())
                ->setLabel('Button URL ('.$locale->uppercase_id.')')
                ->setGroup('Content')
                ->setContainerClass('w-full');

            //->setConditions([['field' => 'projectsupport_type_id', 'value' => CreativeSolution::PROJECTSUPPORT_TYPE_ID]])
        }
        return $fields;
    }

    protected static function addFieldsForTestimonialBlock($cache)
    {
        $fields = [];
        $fields['person_photo'] = (new ImagePickerVueCRUDFormfield())
            ->setLabel('Photo')
            ->setGroup(__('Content'))
            ->setContainerClass('w-full');
        foreach ($cache['locales'] as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('person_first_name')] = (new TextVueCRUDFormfield())
                ->setLabel('First name ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-1/3');
            $fields[$locale->getTranslatedPropertyName('person_last_name')] = (new TextVueCRUDFormfield())
                ->setLabel('Last name ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-1/3');
            $fields[$locale->getTranslatedPropertyName('person_position')] = (new TextVueCRUDFormfield())
                ->setLabel('Position ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-1/3');
            $fields[$locale->getTranslatedPropertyName('button_label')] = (new TextVueCRUDFormfield())
                ->setLabel('Button label ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_url')] = (new TextVueCRUDFormfield())
                ->setLabel('Button URL ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');

            //->setConditions([['field' => 'projectsupport_type_id', 'value' => CreativeSolution::PROJECTSUPPORT_TYPE_ID]])
        }
        return $fields;
    }

    protected static function addFieldsForCTABlock($cache)
    {
        $fields = [];
        $fields['spacing_id'] = (new SelectVueCRUDFormfield())
            ->setLabel('Spacing')
            ->setContainerClass('w-full')
            ->setMandatory(true)
            ->setGroup(__('Formatting'))
            ->setValuesetClass(Spacing::class);

        $fields['background_image'] = (new ImagePickerVueCRUDFormfield())
            ->setLabel('Background image')
            ->setGroup(__('Content'))
            ->setContainerClass('w-full');
        foreach ($cache['locales'] as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_label')] = (new TextVueCRUDFormfield())
                ->setLabel('Button label ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_url')] = (new TextVueCRUDFormfield())
                ->setLabel('Button URL ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');

            //->setConditions([['field' => 'projectsupport_type_id', 'value' => CreativeSolution::PROJECTSUPPORT_TYPE_ID]])
        }
        return $fields;
    }

    protected static function addFieldsForTextImageListBlock($cache)
    {
        $fields = [];
        $fields['layout'] = (new SelectVueCRUDFormfield())
            ->setMandatory(true)
            ->setLabel('Layout')
            ->setGroup(__('Formatting'))
            ->setDefault(TextImageListLayout::FEATURE_LIST_ID)
            ->setValuesetClass(TextImageListLayout::class)
            ->setContainerClass('w-full');
//        $fields['topic_image'] = (new ImagePickerVueCRUDFormfield())
//            ->setLabel('Image')
//            ->setContainerClass('w-full');
        foreach ($cache['locales'] as $locale) {
            $fields[$locale->getTranslatedPropertyName('text_image_lists_title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('text_image_lists_content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-full');
        }
        return $fields;
    }

    protected static function addFieldsForSimpleTextImageBlock($cache)
    {
        $fields = [];
        $fields['topic_image_border_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Image border color')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $fields['topic_image_horizontal_positioning_id'] = (new SelectVueCRUDFormfield())
            ->setLabel('Image positioning')
            ->setContainerClass('w-full')
            ->setGroup(__('Formatting'))
            ->setDefault(Positioning::findByCode('right')->id)
            ->setValuesetClass(Positioning::class)
            ->setValuesetGetter('getHorizontalPositioningOptions');
        foreach ($cache['locales'] as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_label')] = (new TextVueCRUDFormfield())
                ->setLabel('Button label ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_url')] = (new TextVueCRUDFormfield())
                ->setLabel('Button URL ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('topic_image')] = (new ImagePickerVueCRUDFormfield())
                ->setLabel('Image ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');

        }
        return $fields;
    }

    protected static function addFieldsForTextImageListCollectionBlock($cache)
    {
        $fields = [];
        $fields['layout'] = (new SelectVueCRUDFormfield())
            ->setMandatory(true)
            ->setLabel('Layout')
            ->setGroup(__('Formatting'))
            ->setDefault(TextImageListCollectionBlockLayout::TABS_ID)
            ->setValuesetClass(TextImageListCollectionBlockLayout::class)
            ->setContainerClass('w-full');
        $fields['text_color_selected_list'] = (new ColorVueCRUDFormfield())
            ->setLabel('Selected list text color')
            ->setGroup(__('Formatting'))
            ->setStep(2)
            ->setContainerClass('w-1/3')
            ->setPresets(static::getApplicationColorPresets());
        $fields['backgroundtype'] = (new SelectVueCRUDFormfield())
            ->setLabel('Background color type')
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-full')
            ->setStep(2)
            ->setValuesetClass(BackgroundColorType::class)
            ->setDefault(BackgroundColorType::SOLID_ID);
        $fields['background_color_selected_list'] = (new ColorVueCRUDFormfield())
            ->setLabel('Selected list background color')
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $fields['second_background_color_selected_list'] = (new ColorVueCRUDFormfield())
            ->setLabel('Second selected list background color (for gradients)')
            ->setHideIf([
                ['$7_backgroundtype', '=', BackgroundColorType::SOLID_ID]
            ])
            ->setStep(2)
            ->setGroup(__('Formatting'))
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        foreach ($cache['locales'] as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');
        }
        return $fields;
    }

    protected static function addFieldsForFooterBlock($cache)
    {
        $fields = [];
        foreach ($cache['locales'] as $locale) {
            $fields[$locale->getTranslatedPropertyName('site_logo')] = (new ImagePickerVueCRUDFormfield())
                ->setLabel('Site logo ('.$locale->uppercase_id.')')
                ->setGroup(__('Content'))
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('row_2_content_1')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Row 2 content block 1 ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setGroup(__('Content'))
                ->setCustomOptions(['cssHeight' => '400px'])
                ->setProps(['cssHeight' => '120px'])
                ->setContainerClass('w-1/4');
            $fields[$locale->getTranslatedPropertyName('row_2_content_2')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Row 2 content block 2 ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setGroup(__('Content'))
                ->setCustomOptions(['cssHeight' => '400px'])
                ->setProps(['cssHeight' => '120px'])
                ->setContainerClass('w-1/4');
            $fields[$locale->getTranslatedPropertyName('row_2_content_3')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Row 2 content block 3 ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setGroup(__('Content'))
                ->setCustomOptions(['cssHeight' => '400px'])
                ->setProps(['cssHeight' => '120px'])
                ->setContainerClass('w-1/4');
            $fields[$locale->getTranslatedPropertyName('row_2_content_4')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Row 2 content block 4 ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setGroup(__('Content'))
                ->setCustomOptions(['cssHeight' => '400px'])
                ->setProps(['cssHeight' => '120px'])
                ->setContainerClass('w-1/4');
            $fields[$locale->getTranslatedPropertyName('row_3_content_1_copyright')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Copyright ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setGroup(__('Content'))
                ->setCustomOptions(['cssHeight' => '400px'])
                ->setProps(['cssHeight' => '120px'])
                ->setContainerClass('w-1/4');
            $fields[$locale->getTranslatedPropertyName('row_3_content_2_imprint')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Imprint ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setGroup(__('Content'))
                ->setCustomOptions(['cssHeight' => '400px'])
                ->setProps(['cssHeight' => '120px'])
                ->setContainerClass('w-1/4');
            $fields[$locale->getTranslatedPropertyName('row_3_content_3_terms_of_use')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Terms of use ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setCustomOptions(['cssHeight' => '400px'])
                ->setGroup(__('Content'))
                ->setProps(['cssHeight' => '120px'])
                ->setContainerClass('w-1/4');
            $fields[$locale->getTranslatedPropertyName('row_3_content_4_privacy')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Privacy ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setGroup(__('Content'))
                ->setCustomOptions(['cssHeight' => '400px'])
                ->setProps(['cssHeight' => '120px'])
                ->setContainerClass('w-1/4');
        }
        return $fields;
    }

    public function __construct(Block $subject = null, $defaults = [])
    {
        $this->subject = $subject;
        $this->defaults = $defaults;
        $this->addStepLabel(1, __('1) Block type'));
        $this->addStepLabel(2, __('2) Block properties'));
    }

    public function getFormfieldValue($field)
    {
        $pieces = explode('_', $field, 2);
        if (!is_numeric($pieces[0])) {
            return false;
        }
        if ($this->subject == null) {
            return null;
        }
        if ($this->subject instanceof IHasItemsContainer) {

            if (\Str::startsWith($pieces[1], $this->subject->getItemsContainer()->getTable())) {
                $newField = str_ireplace(
                    $this->subject->getItemsContainer()->getTable().'_',
                    '',
                    $pieces[1]
                );
                return $this->subject->getItemsContainer()->$newField;
            }
        }
        return $this->subject->{$pieces[1]};
    }

    public function get_second_background_color_value()
    {
        if ($this->subject == null) {
            return null;
        }
        if ($this->subject->background_gradient == null) {
            return null;
        }
        $data = BlockStyledefinition::parseGradientCSSDefinition($this->subject->background_gradient);

        return $data['color2'];
    }

    public function get_7_second_background_color_value()
    {
        if ($this->subject == null) {
            return null;
        }
        if ($this->subject->background_gradient_selected_list == null) {
            return null;
        }
        $data = BlockStyledefinition::parseGradientCSSDefinition($this->subject->background_gradient_selected_list);

        return $data['color2'];
    }

    public function get_1_background_image_value()
    {
        if (($this->subject == null) || ($this->subject->background_image == null)) {
            return null;
        }

        return asset('storage'
            .DIRECTORY_SEPARATOR
            .'attachments'
            .DIRECTORY_SEPARATOR
            .$this->subject->background_image);
    }

    public function get_backgroundtype_value()
    {
        if ($this->subject == null) {
            return BackgroundColorType::SOLID_ID;
        }
        return $this->subject->background_gradient == null
            ? BackgroundColorType::SOLID_ID
            : BackgroundColorType::GRADIENT_ID;
    }

    public function get_7_backgroundtype_value()
    {
        if ($this->subject == null) {
            return BackgroundColorType::SOLID_ID;
        }
        return $this->subject->background_gradient == null
            ? BackgroundColorType::SOLID_ID
            : BackgroundColorType::GRADIENT_ID;
    }
}
