<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Role;
use App\Traits\SeparatesAdminAuth;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Validation\Rule;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails, SeparatesAdminAuth;

    /**
     * Display the form to request a password reset link.
     *
     * @return \Illuminate\View\View
     */
    public function showLinkRequestForm()
    {
        if ($this->isAdminAttempt()) {
            return view('admin.auth.passwords.email');
        }
        return view('auth.passwords.email');
    }


    /**
     * Validate the email for the given request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        if ($this->isAdminAttempt()) {
            $request->validate(['email' => [
                'required',
                'email',
                Rule::exists('users')->where(function($query) {return $query->whereIn('role_id', Role::where('is_admin', '=', 1)->get()->pluck('id')->all());})]
            ], ['exists' => __('passwords.user')]);
        } else {
            $request->validate(['email' => [
                'required',
                'email',
                Rule::exists('users')->where(function($query) {return $query->whereNotIn('role_id', Role::where('is_admin', '=', 1)->get()->pluck('id')->all());})]
            ], ['exists' => __('passwords.user')]);
        }
    }

}
