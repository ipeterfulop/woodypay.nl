<?php

namespace App\Http\Requests;

use App\Formdatabuilders\BlockVueCRUDFormdatabuilder;
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
                $subject = $class::createWithTranslations($this->getDataset());
                dd($subject);
                BlockPage::create([
                    'page_id' => $pageId,
                    'block_id' => $subject->id,
                    'position' => $position,
                ]);
            });

        } else {
            $subject->update($this->getDataset());
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
            'background_gradient' => $this->input('background_gradient'),
            'button_background_color' => $this->input('button_background_color'),
        ];
        $this->blockType = BlockType::find($result['blocktype_id']);
        foreach($this->getBlockFields() as $field) {
            $result[$field] = $this->input($field);
        }

        return $result;
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
