<?php


namespace App\Formdatabuilders;


use App\Models\Block;
use App\Models\BlockType;
use App\Models\Locale;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\SelectVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\Formfieldtypes\TextVueCRUDFormfield;
use Datalytix\VueCRUD\Formdatabuilders\VueCRUDFormdatabuilder;

class BlockVueCRUDFormdatabuilder extends VueCRUDFormdatabuilder
{
    /**
     * @return Illuminate\Support\Collection;
     * returns a collection of VueCRUDFormfield descendants that
     * define what the edit/create forms will contain
     */
    protected static function getFields()
    {
        $result = [];
        $result['blocktype_id'] = (new SelectVueCRUDFormfield())
            ->setStep(1)
            ->setMandatory(true)
            ->setLabel('Block type')
            ->setValuesetClass(BlockType::class);
        foreach(BlockType::all() as $blockType) {
            $result = static::addFieldsBasedOnBlocktype($result, $blockType);
        }

        return collect($result);
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