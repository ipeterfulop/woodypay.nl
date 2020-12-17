<?php

namespace App\Http\Middleware;

use App\Exceptions\DisabledUserException;
use Closure;
use Illuminate\Http\Request;

class CheckDisabledStatusOnUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ((\Auth::check()) && (\Auth::user()->isDisabled())) {
            throw new DisabledUserException(__('Inaktív fiók.'));
        }
        return $next($request);
    }
}
