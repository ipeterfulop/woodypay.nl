<?php

namespace App\Listeners;

use App\Helpers\UseractionType;
use App\Models\Useraction;
use Illuminate\Auth\Events\Failed;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class LogFailedloginUseraction
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
     * @param  Failed  $event
     * @return void
     */
    public function handle(Failed $event)
    {
        Useraction::create([
            'user_id' => $event->user->id,
            'actiontype_id' => UseractionType::FAILED_LOGIN_ID
        ]);
    }
}
