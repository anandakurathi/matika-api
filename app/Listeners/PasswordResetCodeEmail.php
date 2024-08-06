<?php

namespace App\Listeners;

use App\Events\PasswordResetCode;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Mail\PasswordResetCodeEmail as MailPasswordResetCode;
use Illuminate\Support\Facades\Mail;

class PasswordResetCodeEmail
{

    /**
     * Handle the event.
     */
    public function handle(PasswordResetCode $event): void
    {
        $data = $event->data;

        Mail::to($data)
            ->send(new MailPasswordResetCode($data));
    }
}
