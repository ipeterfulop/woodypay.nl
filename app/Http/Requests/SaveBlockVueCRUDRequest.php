<?php

namespace App\Http\Requests;

use App\BlockStyledefinition;
use App\Formdatabuilders\BlockVueCRUDFormdatabuilder;
use App\Helpers\BackgroundColorType;
use App\Models\Block;
use App\Models\BlockPage;
use App\Models\BlockType;
use App\Models\HeroBlock;
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
                    $class = $this->blockType->item_class;

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
            $subClass->updateWithTranslations($dataset);
        }

        return $subject;
    }

    public function getDataset()
    {
        $result = [
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
        foreach($this->getBlockFields() as $field) {
            $result[$field] = $this->getParsedInputValue($this->blockType->id.'_'.$field);
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
