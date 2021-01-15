<?php

namespace App\Http\Controllers;

use App\ViralLoopsConnector;
use Illuminate\Http\Request;

class CampaignRegistrationController extends Controller
{
    public function register()
    {
        $vl = new ViralLoopsConnector();
        dd($vl->register(
            request()->get('firstname'),
            request()->get('lastname'),
            request()->get('email'),
        ));
    }
}
