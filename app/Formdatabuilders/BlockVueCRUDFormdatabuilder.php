<?php


namespace App\Formdatabuilders;


use App\BlockStyledefinition;
use App\Helpers\BackgroundColorType;
use App\Models\Block;
use App\Models\BlockType;
use App\Models\IHasItemsContainer;
use App\Models\Locale;
use App\Models\Page;
use App\Models\Positioning;
use App\Models\Spacing;
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

    protected static function getApplicationColorPresets()
    {
        //todo, when the design is in
        return [];
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
        $result = static::addBaseBlockFields($result);
        foreach(BlockType::all() as $blockType) {
            $result = static::addFieldsBasedOnBlocktype($result, $blockType);
        }

        return collect($result);
    }

    protected static function addBaseBlockFields($result)
    {
        $result['text_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Text color')
            ->setStep(2)
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $result['backgroundtype'] = (new SelectVueCRUDFormfield())
            ->setLabel('Background color type')
            ->setContainerClass('w-full')
            ->setStep(2)
            ->setValuesetClass(BackgroundColorType::class)
            ->setDefault(BackgroundColorType::SOLID_ID);
        $result['background_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Background color')
            ->setStep(2)
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $result['second_background_color'] = (new ColorVueCRUDFormfield())
            ->setHideIf([
                ['$backgroundtype', '=', BackgroundColorType::SOLID_ID]
            ])
            ->setLabel('Second background color (for gradients)')
            ->setStep(2)
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $result['should_open_button_url_in_new_window'] = (new YesNoSelectVueCRUDFormfield())
            ->setValuesetClass(YesNoValueset::class)
            ->setLabel('Open button URL in new window (if applicable)')
            ->setStep(2)
            ->setDefault(0)
            ->setContainerClass('w-full');
        $result['button_background_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button background color')
            ->setStep(2)
            ->setContainerClass('w-1/4')
            ->setPresets(static::getApplicationColorPresets());
        $result['button_text_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button text color')
            ->setStep(2)
            ->setContainerClass('w-1/4')
            ->setPresets(static::getApplicationColorPresets());
        $result['button_hover_background_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button background color (hover)')
            ->setStep(2)
            ->setContainerClass('w-1/4')
            ->setPresets(static::getApplicationColorPresets());
        $result['button_hover_text_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button text color (hover)')
            ->setStep(2)
            ->setContainerClass('w-1/4')
            ->setPresets(static::getApplicationColorPresets());

        return $result;
    }

    protected static function addFieldsBasedOnBlocktype($result, BlockType $blockType)
    {
        $methodName = 'addFieldsFor'.$blockType->getClassNameFromTag();
        if (!method_exists(new self(), $methodName)) {
            throw new \Exception('Invalid formbuilder method: '.$methodName);
        }
        $fields = static::$methodName($result);
        $prefix = $blockType->id.'_';
        foreach ($fields as $key => $field) {
            $result[$prefix.$key] = $field;
            $result[$prefix.$key]->setConditions([['field' => 'blocktype_id', 'value' => $blockType->id]]);
            $result[$prefix.$key]->setStep(2);
        }

        return $result;
    }

    protected static function addFieldsForHeroBlock()
    {
        $fields = [];
        $fields['background_image'] = (new ImagePickerVueCRUDFormfield())
            ->setLabel('Background image')
            ->setContainerClass('w-full');
        $fields['background_image_positioning_id'] = (new SelectVueCRUDFormfield())
            ->setLabel('Background image positioning')
            ->setContainerClass('w-full')
            ->setValuesetClass(Positioning::class)
            ->setValuesetGetter('getBackgroundPositioningOptions');
        foreach (Locale::all() as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_label')] = (new TextVueCRUDFormfield())
                ->setLabel('Button label ('.$locale->uppercase_id.')')
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_url')] = (new TextVueCRUDFormfield())
                ->setLabel('Button URL ('.$locale->uppercase_id.')')
                ->setContainerClass('w-full');

            //->setConditions([['field' => 'projectsupport_type_id', 'value' => CreativeSolution::PROJECTSUPPORT_TYPE_ID]])
        }
        return $fields;
    }

    protected static function addFieldsForCTABlock()
    {
        $fields = [];
        $fields['spacing_id'] = (new SelectVueCRUDFormfield())
            ->setLabel('Spacing')
            ->setContainerClass('w-full')
            ->setMandatory(true)
            ->setValuesetClass(Spacing::class);

        $fields['background_image'] = (new ImagePickerVueCRUDFormfield())
            ->setLabel('Background image')
            ->setContainerClass('w-full');
        foreach (Locale::all() as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_label')] = (new TextVueCRUDFormfield())
                ->setLabel('Button label ('.$locale->uppercase_id.')')
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_url')] = (new TextVueCRUDFormfield())
                ->setLabel('Button URL ('.$locale->uppercase_id.')')
                ->setContainerClass('w-full');

            //->setConditions([['field' => 'projectsupport_type_id', 'value' => CreativeSolution::PROJECTSUPPORT_TYPE_ID]])
        }
        return $fields;
    }

    protected static function addFieldsForTextImageListBlock()
    {
        $fields = [];
//        $fields['topic_image'] = (new ImagePickerVueCRUDFormfield())
//            ->setLabel('Image')
//            ->setContainerClass('w-full');
        foreach (Locale::all() as $locale) {
            $fields[$locale->getTranslatedPropertyName('text_image_lists_title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('text_image_lists_content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
        }
        return $fields;
    }

    protected static function addFieldsForSimpleTextImageBlock()
    {
        $fields = [];
        $fields['topic_image_border_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Image border color')
            ->setStep(2)
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $fields['topic_image_horizontal_positioning_id'] = (new SelectVueCRUDFormfield())
            ->setLabel('Image positioning')
            ->setContainerClass('w-full')
            ->setDefault(Positioning::findByCode('right')->id)
            ->setValuesetClass(Positioning::class)
            ->setValuesetGetter('getHorizontalPositioningOptions');
        foreach (Locale::all() as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('content')] = (new RichttextQuillVueCRUDFormfield())
                ->setLabel('Content ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_label')] = (new TextVueCRUDFormfield())
                ->setLabel('Button label ('.$locale->uppercase_id.')')
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('button_url')] = (new TextVueCRUDFormfield())
                ->setLabel('Button URL ('.$locale->uppercase_id.')')
                ->setContainerClass('w-full');
            $fields[$locale->getTranslatedPropertyName('topic_image')] = (new ImagePickerVueCRUDFormfield())
                ->setLabel('Image ('.$locale->uppercase_id.')')
                ->setContainerClass('w-full');

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
}
