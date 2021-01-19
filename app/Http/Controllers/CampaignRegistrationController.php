<?php

namespace App\Http\Controllers;

use App\MultiStepForm;
use App\ViralLoopsConnector;
use Illuminate\Http\Request;

class CampaignRegistrationController extends Controller
{
    protected $routeName = 'campaign_registration_endpoint';
    protected $partialView = 'signup-form-partial';
    protected $finishView = 'wlt';
    protected $view = 'wlt';

    public function index()
    {
        return view($this->view, [
            'form' => $this->getForm(),
            'formId' => 'registerform',
            'step' => 1,
            'endpoint' => route($this->routeName)
        ]);
    }

    public function endpoint()
    {
        $step = request()->input('step', 1);
        $form = $this->getForm();
        if (!$form->stepExists($step)) {
            abort(404);
        }
        if ($form->isStepFinal($step)) {
            return view($this->partialView, ['form' => $form]);
        }


    }

    protected function getForm()
    {
        return new MultiStepForm([
            1 => [
                'firstname' => ['label' => __('First name'), 'type' => 'text', 'subtype' => 'text', 'required' => true],
                'lastname' => ['label' => __('Last name'), 'type' => 'text', 'subtype' => 'text', 'required' => true],
                'email' => ['label' => __('Email'), 'type' => 'text', 'subtype' => 'email', 'required' => true],
            ],
            2 => [
                'dob' => ['label' => __('Date of birth'), 'type' => 'text', 'subtype' => 'date', 'required' => true],
                'phone' => ['label' => __('Phone'), 'type' => 'text', 'subtype' => 'text', 'required' => true],
            ],
        ], request()->input());
    }
}
