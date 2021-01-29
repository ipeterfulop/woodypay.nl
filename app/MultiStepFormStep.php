<?php


namespace App;


class MultiStepFormStep
{
    public $fields = [];
    public $title = '';
    public $description = '';

    public function __construct($fields, $title, $description)
    {
        $this->fields = $fields;
        $this->title = $title;
        $this->description = $description;
    }

    public function setValue($field, $value)
    {
        $this->fields[$field]['value'] = $value;
    }

    public function getDefaultFieldValue($field)
    {
        return isset($this->fields[$field]['default']) ? $this->fields[$field]['default'] : null;
    }

    public function getRules()
    {
        $result = [];
        foreach ($this->fields as $field => $fieldData) {
            $result[$field] = isset($fieldData['rules']) ? $fieldData['rules'] : [];
        }

        return $result;
    }

    public function getMessages()
    {
        $result = [];
        foreach ($this->fields as $field => $fieldData) {
            $result[$field] = isset($fieldData['messages']) ? $fieldData['messages'] : [];
        }

        return $result;
    }

}