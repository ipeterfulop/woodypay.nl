<?php


namespace App;


class MultiStepForm
{
    protected $steps = [];
    const FINAL_STEP_IDENTIFIER = 'final';

    public function __construct($steps, $requestData)
    {
        $this->steps = $steps;
        $this->setFormDataFromRequestData($requestData);
    }

    protected function setFormDataFromRequestData($requestData)
    {
        foreach ($this->steps as $step => $fields) {
            foreach ($fields as $field => &$data) {
                $data['value'] = isset($requestData[$field]) ? $requestData[$field] : null;
            }
        }

        return $this;
    }

    public function getStepValidator($step, $data)
    {
        return \Validator::make($data, $this->steps[$step]['rules'], $this->steps[$step]['messages']);
    }

    public function stepExists($step)
    {
        return isset($this->steps[$step]);
    }

    public function isStepFinal($step)
    {
        return $step == self::FINAL_STEP_IDENTIFIER;
    }

    public function upcomingStep($currentStep)
    {
        $next = intval($currentStep) + 1;
        if (!$this->stepExists($next)) {
            return self::FINAL_STEP_IDENTIFIER;
        }

        return $next;
    }
}