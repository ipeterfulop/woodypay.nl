<?php


namespace App;


use App\Models\Block;
use App\Models\Positioning;

class BlockStyledefinition
{
    public $arrayOfStyleDefinitions;

    public function __construct($arrayOfStyleDefinitions)
    {
        $this->arrayOfStyleDefinitions = $arrayOfStyleDefinitions;
    }

    public function getStyleString()
    {
        $elements = [];

        foreach ($this->arrayOfStyleDefinitions as $key => $value) {
            $elements[] = $key.': '.$value;
        }

        return implode('; ', $elements);
    }

    public static function getCSSGradientBackgroundDefinition($color1, $color2, $sideOrCorner = 'to bottom')
    {
        return 'linear-gradient('.$sideOrCorner.', '.$color1.', '.$color2.')';
    }

    public static function parseGradientCSSDefinition($definition)
    {
        $definition = str_ireplace('linear-gradient', '', $definition);
        $definition = mb_substr($definition, 1, mb_strlen($definition) - 2);
        $pieces = explode(',', $definition, 2);
        $result = [
            'sideOrCorner' => trim($pieces[0]),
            'color1' => 'auto',
            'color2' => 'auto',
        ];
        $definition = trim($pieces[1]);
        $colors = [];
        $currentColor = '';
        $pStack = 0;
        for ($t = 0; $t < mb_strlen($definition); $t++) {
            $char = mb_substr($definition, $t, 1);
            if ($char == '(') {
                $pStack++;
            }
            if ($char == ')') {
                $pStack--;
            }
            if (($char == ',') && ($pStack == 0)) {
                $colors[] = $currentColor;
                $currentColor = '';
            } else {
                $currentColor .= $char;
            }
        }
        if ($currentColor != '') {
            $colors[] = $currentColor;
        }
        if (isset($colors[0])) {
            $result['color1'] = trim($colors[0]);
        }
        if (isset($colors[1])) {
            $result['color2'] = trim($colors[1]);
        }

        return $result;
    }

    public static function getCSSClasses(Block $block)
    {
        $blockClassname = $block->getBlockCSSName();
        $result = [];
        $result[$blockClassname] = self::removeEmptyDefinitions([
            'color' => $block->text_color,
            'background-color' => $block->background_color,
            'background' => $block->background_gradient,
            'background-image' => $block->background_image == null ? null : 'url("/images'.$block->background_image.'")',
            'background-position' => $block->background_image_positioning_id == null ? 'center' : Positioning::find($block->background_image_positioning_id)->code,
            'padding-top' => $block->spacing_id == null ? null : $block->spacing->size_in_rems.'rem',
            'padding-bottom' => $block->spacing_id == null ? null : $block->spacing->size_in_rems.'rem',
        ]);
        $result[$blockClassname.' a.button'] = self::removeEmptyDefinitions([
            'color' => $block->button_text_color,
            'background-color' => $block->button_background_color,
        ]);
        $result[$blockClassname.' a.button:hover'] = self::removeEmptyDefinitions([
            'color' => $block->button_hover_text_color,
            'background-color' => $block->button_hover_background_color,
        ]);
        $resultString = '';
        foreach ($result as $name => $items) {
            $resultString .= '.'.$name.' {';
            foreach($items as $field => $value) {
                $resultString.=$field.': '.$value.';';
            }
            $resultString .= '}';
        }

        return $resultString;
    }

    protected static function removeEmptyDefinitions(array $definitions)
    {
        return collect($definitions)->filter(function($item) {
            return $item !== null && $item != 'auto';
        });
    }
}