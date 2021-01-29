<?php

namespace App\Http\Controllers;

use App\Helpers\Spendingcategory;
use App\MultiStepForm;
use App\MultiStepFormStep;
use App\ViralLoopsConnector;
use App\ViralLoopsSignup;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CampaignRegistrationController extends Controller
{
    protected $routeName = 'campaign_registration_endpoint';
    protected $partialView = 'signup-form-partial';
    protected $finishView = 'campaign-reg-finished';
    protected $view = 'wlt';

    public function index()
    {
        return view($this->view, [
            'form'     => $this->getForm(),
            'formId'   => 'registerform',
            'step'     => 1,
            'endpoint' => route($this->routeName),
        ]);
    }

    public function test()
    {
        $dataset = [
            'firstname' => 'Tamás',
            'lastname'  => 'Oláh',
            'email'     => 'caleb@caleb.hu',
            'extraData' => ['testing' => '1,2,3'],
        ];

        $v = new ViralLoopsSignup($dataset['firstname'], $dataset['lastname'], $dataset['email']);
        $v->setAdditionalData($dataset['extraData']);
        $vl = new ViralLoopsConnector('BAWYcpYJm566FqTDwXQ6a7Yfl4Q');
        //$dataset['referralCode'] = $vl->register($v);

        return view('welcome', [
            'dataset' => $dataset,
        ]);
    }

    public function endpoint()
    {
        $step = request()->input('step', 1);
        $form = $this->getForm();

        if (! $form->stepValid($step)) {
            abort(404);
        }
        if ($form->stepExists(request()->input('currentStep'))) {
            $validator = $form->getStepValidator(request()->input('currentStep'), request()->input());
            if ($validator->fails()) {
                throw (new ValidationException($validator))
                    ->errorBag($validator->errors())
                    ->redirectTo('/');
            }
        }

        if ($form->isStepFinal($step)) {
            return view($this->finishView);
        }

        return view($this->partialView, [
            'step'      => $form->getStep($step),
            'nextIndex' => $form->upcomingStep($step),
            'currentStep' => $step,
        ]);
    }

    protected function getForm()
    {

        return new MultiStepForm([
            1 => new MultiStepFormStep([
                'email'     => [
                    'label'    => __('Email'),
                    'type'     => 'text',
                    'subtype'  => 'email',
                    'rules' => ['required', 'email'],
                ],
            ], 'Sign up', 'Sign up!'),
            2 => new MultiStepFormStep(
                    [
                        'firstname' => [
                            'label'    => __('First name'),
                            'type'     => 'text',
                            'subtype'  => 'text',
                            'rules' => ['required'],
                        ],
                        'lastname'  => [
                            'label'    => __('Last name'),
                            'type'     => 'text',
                            'subtype'  => 'text',
                            'rules' => ['required'],
                        ],
                        'email'     => [
                            'label'    => __('Email'),
                            'type'     => 'text',
                            'subtype'  => 'email',
                            'rules' => ['required', 'email'],
                        ],
                    ],
                    'Sign up!',
                'Vivamus ex tortor, pellentesque nec magna sit amet, varius fringilla ipsum. Ut rhoncus sapien ut nibh aliquam interdum. Quisque vulputate tincidunt felis, vel varius magna bibendum in.'
            ),
            3 => new MultiStepFormStep(
                    ['dob'   => [
                            'label'    => __('Date of birth'),
                            'type'     => 'text',
                            'subtype'  => 'date',
                            'rules' => ['required', 'date']
                        ],
                        'phone' => ['label' => __('Phone'), 'type' => 'text', 'subtype' => 'text', 'required' => true],
                    ],
                    'Personal information',
                'Personal info'
            ),
            4 => new MultiStepFormStep([
                'spendingcategory_id' => [
                    'label' => 'How much do you plan on spending a month in your local currency?',
                    'type' => 'select',
                    'subtype' => null,
                    'valueset' => Spendingcategory::getKeyValueCollection()->all()
                ]
            ], 'Other', 'misc')
        ], request()->input());
    }
}
