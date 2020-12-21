<?php


namespace App\Formdatabuilders;


use App\Helpers\BackgroundColorType;
use App\Models\Block;
use App\Models\BlockType;
use App\Models\Locale;
use App\Models\Page;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\ColorVueCRUDFormfield;
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
        if (request()->has('page_id')) {
            $result['page_id'] = (new StaticVueCRUDFormfield())
                ->setDefault(request()->get('page_id'))
                ->setStaticValue('')
                ->setContainerClass('col-12 hidden');
        } else {
            $result['page_id'] = (new SelectVueCRUDFormfield())
                ->setLabel('Page')
                ->setMandatory(true)
                ->setContainerClass('col-12')
                ->setValuesetClass(Page::class);
        }
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
            ->setContainerClass('w-1/2')
            ->setPresets(static::getApplicationColorPresets());
        $result['button_text_color'] = (new ColorVueCRUDFormfield())
            ->setLabel('Button text color')
            ->setStep(2)
            ->setContainerClass('w-1/2')
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

    protected static function addFieldsForSimpleTextImageBlock()
    {
        $fields = [];
        foreach (Locale::all() as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');

            //->setConditions([['field' => 'projectsupport_type_id', 'value' => CreativeSolution::PROJECTSUPPORT_TYPE_ID]])
        }
        return $fields;
    }

    protected static function addFieldsForTextImageListBlock()
    {
        $fields = [];
        foreach (Locale::all() as $locale) {
            $fields[$locale->getTranslatedPropertyName('title')] = (new TextVueCRUDFormfield())
                ->setLabel('Title ('.$locale->uppercase_id.')')
                ->setMandatory(true)
                ->setContainerClass('w-full');

            //->setConditions([['field' => 'projectsupport_type_id', 'value' => CreativeSolution::PROJECTSUPPORT_TYPE_ID]])
        }
        return $fields;
    }

    public function __construct(Block $subject = null, $defaults = [])
    {
        $this->subject = $subject;
        $this->defaults = $defaults;
        $this->addStepLabel(1, __('First, select a block type'));
        $this->addStepLabel(2, __('Set the block\'s properties'));
    }
}