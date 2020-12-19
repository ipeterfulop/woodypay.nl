<?php

namespace App\Http\Controllers;

use App\BlockStyledefinition;
use App\Models\Locale;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

class PublicMainController extends Controller
{
    public function index()
    {
        $locale = Locale::getMainLocale();

        //return redirect()
    }

    public function profile()
    {
        return view('members.profile');
    }

    public function verificationNotice()
    {
        return view('members.verification-notice');
    }

    public function verifyEmail(EmailVerificationRequest $request)
    {
        $request->fulfill();

        return view('members.verification-complete');
    }

    public function sendVerificationLink()
    {
        \Auth::user()->sendEmailVerificationNotification();
        return view('members.verification-notice', ['verificationLinkSent' => true]);
    }
}
