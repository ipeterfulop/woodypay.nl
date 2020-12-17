<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $token;
    public $url;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(User $user, $token, $url)
    {
        $this->user = $user;
        $this->token = $token;
        $this->url = $url;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mail.reset-password')
            ->to($this->user->email)
            ->subject(__('Új jelszó létrehozása').' - '.config('app.name'));
    }
}
