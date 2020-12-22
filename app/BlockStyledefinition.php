<?php


namespace App;


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
}