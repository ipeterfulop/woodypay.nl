<?php


namespace App;


class MultiStepForm
{
    protected $steps = [];

    public function __construct($steps, $requestData)
    {
        $this->steps = $steps;
        $this->setFormDataFromRequestData($requestData);
    }

    protected function setFormDataFromRequestData($requestData)
    {
        foreach ($this->steps as $step) {
            foreach ($step->fields as $field => $data) {
                $step->setValue(
                    $field,
                    isset($requestData[$field]) ? $requestData[$field] : $step->getDefaultFieldValue($field)
                );
            }
        }

        return $this;
    }

    public function getStepValidator($step, $data)
    {
        return \Validator::make($data, $this->steps[$step]->getRules(), $this->steps[$step]->getMessages());
    }

    public function stepExists($step)
    {
        return isset($this->steps[$step]);
    }

    public function stepValid($step)
    {
        return isset($this->steps[$step]) || $step == count($this->steps) + 1;
    }

    public function isStepFinal($step)
    {
        return count($this->steps) == $step - 1;
    }

    public function upcomingStep($currentStep)
    {
        $next = intval($currentStep) + 1;

        return $next;
    }

    public function getStep($index)
    {
        return $this->steps[$index];
    }
}