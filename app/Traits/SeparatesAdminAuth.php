<?php


namespace App\Traits;


trait SeparatesAdminAuth
{
    protected function isAdminAttempt()
    {
        return (request()->routeIs('admin.*'));
    }
}