<?php

namespace App\Http\Requests;

use App\BlockStyledefinition;
use App\Formdatabuilders\BlockVueCRUDFormdatabuilder;
use App\Helpers\BackgroundColorType;
use App\Models\Block;
use App\Models\BlockPage;
use App\Models\BlockType;
use App\Models\HeroBlock;
use App\Models\IHasItemsContainer;
use App\Models\Locale;
use Datalytix\Translations\TranslatableModel;
use Datalytix\VueCRUD\Requests\VueCRUDRequestBase;

class SaveBlockVueCRUDRequest extends VueCRUDRequestBase
{
    const FORMDATABUILDER_CLASS = BlockVueCRUDFormdatabuilder::class;
    protected $blockType = null;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function save(Block $subject = null)
    {
        $dataset = $this->getDataset();
        $class = '\\App\\Models\\'.$this->blockType->getClassNameFromTag();
        if ($subject == null) {
            $position = BlockPage::getFirstAvailablePosition(['page_id' => $dataset['page_id']]);
            $pageId = $dataset['page_id'];
            unset($dataset['page_id']);
            \DB::transaction(function() use ($dataset, $class, &$subject, $position, $pageId) {
                if ($this->blockType->item_class != null) {
                    $containerClass = $this->blockType->item_class;
                    $table = $this->blockType->id.'_'.(new $containerClass())->getTable();
                    $itemsContainerDataset = [];
                    foreach ($this->all() as $field => $value) {
                        if (\Str::startsWith($field, $table)) {
                            $itemsContainerDataset[str_ireplace($table.'_', '', $field)] = $value;
                        }
                    }
                    $itemsContainer = $containerClass::createWithTranslations($itemsContainerDataset);
                    $dataset[$class::getItemsContainerIDField()] = $itemsContainer->id;
                }
                $subject = $class::createWithTranslations($dataset);
                BlockPage::create([
                    'page_id' => $pageId,
                    'block_id' => $subject->id,
                    'position' => $position,
                ]);
            });

        } else {
            $subClass = $class::find($subject->id);
            if ($subClass instanceof IHasItemsContainer) {
                unset($dataset[$subClass::getItemsContainerIDField()]);
                $table = $this->blockType->id.'_'.($subClass->getItemsContainer())->getTable();
                $itemsContainerDataset = [];
                foreach ($this->all() as $field => $value) {
                    if (\Str::startsWith($field, $table)) {
                        $itemsContainerDataset[str_ireplace($table.'_', '', $field)] = $value;
                    }
                }
                $subClass->getItemsContainer()->updateWithTranslations($itemsContainerDataset);
            }
            $subClass->updateWithTranslations($dataset);
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = [
            'internal_name' => $this->input('internal_name'),
            'widthtype' => $this->input('widthtype'),
            'page_id' => $this->input('page_id'),
            'blocktype_id' => $this->input('blocktype_id'),
            'text_color' => $this->input('text_color'),
            'background_color' => $this->input('background_color'),
            'button_background_color' => $this->input('button_background_color'),
            'button_text_color' => $this->input('button_text_color'),
            'button_hover_background_color' => $this->input('button_hover_background_color'),
            'button_hover_text_color' => $this->input('button_hover_text_color'),
            'should_open_button_url_in_new_window' => $this->input('should_open_button_url_in_new_window'),
        ];
        if ($this->input('backgroundtype') == BackgroundColorType::GRADIENT_ID) {
            $result['background_gradient'] = BlockStyledefinition::getCSSGradientBackgroundDefinition(
                $this->input('background_color'),
                $this->input('second_background_color')
            );
        }
        $this->blockType = BlockType::find($result['blocktype_id']);
        if ($this->has($this->blockType->id.'_layout')) {
            $result['layout'] = $this->get($this->blockType->id.'_layout');
        }
        $mainLocale = Locale::getMainLocale();
        foreach($this->getBlockFields() as $field) {
            $result[$field] = $this->getParsedInputValue($this->blockType->id.'_'.$field);
            if (\Str::endsWith($field, '_'.$mainLocale->id)) {
                $result[str_ireplace('_'.$mainLocale->id, '', $field)] = $result[$field];
            }
        }
        //special cases of blocks
        if ($this->has('7_backgroundtype')) {
            if ($this->input('7_backgroundtype') == BackgroundColorType::GRADIENT_ID) {
                $result['background_gradient_selected_list'] = BlockStyledefinition::getCSSGradientBackgroundDefinition(
                    $this->input('7_background_color_selected_list'),
                    $this->input('7_second_background_color_selected_list')
                );
            }
        }

        return $result;
    }

    protected function getParsedInputValue($field)
    {
        if (\Str::endsWith($field, 'image')) {
            return basename($this->input($field));
        }

        return $this->input($field);
    }

    protected function getBlockFields()
    {
        $class = '\\App\\Models\\'.$this->blockType->getClassNameFromTag();
        $model = new $class();
        $result = $model->getFillable();
        if (isset($result['id'])) {
            unset($result['id']);
        }
        if ($model instanceof TranslatableModel) {
            foreach($class::getTranslatedProperties() as $field) {
                foreach (Locale::all() as $locale) {
                    $result[] = $locale->getTranslatedPropertyName($field);
                }
            }
        }

        return $result;
    }
}
