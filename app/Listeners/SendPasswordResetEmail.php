<?php

namespace App\Listeners;

use App\Mail\PasswordResetEmail;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmail
{
    /**
     * Handle the event.
     *
     * @param  PasswordReset  $event
     *
     * @return void
     */
    public function handle(PasswordReset $event): void
    {
        $user = $event->user;

        Mail::to($user)
            ->send(new PasswordResetEmail($user));
    }
}
