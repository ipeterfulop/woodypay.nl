<?php

namespace App\Listeners;

use App\Helpers\UseractionType;
use App\Models\Useraction;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogLoginUseraction
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  Login  $event
     * @return void
     */
    public function handle(Login $event)
    {
        Useraction::create([
            'user_id' => $event->user->id,
            'actiontype_id' => UseractionType::LOGIN_ID
        ]);
    }
}
