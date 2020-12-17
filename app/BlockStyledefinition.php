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
}