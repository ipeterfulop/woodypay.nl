<?php


namespace App\Traits;


trait RedirectsAfterAuthentication
{
    public function redirectTo()
    {
        if (!\Auth::check()) {
            return '/';
        }
        return \Auth::user()->getHomeUrl();
    }
}