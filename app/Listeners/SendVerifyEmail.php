<?php

namespace App\Listeners;

use App\Mail\VerifyMail;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use App\Events\UserRegistered;
use App\Notifications\VerifyNotification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendVerifyEmail
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
     * @param  \App\Events\UserRegistered  $event
     * @return void
     */
    public function handle(UserRegistered $event)
    {
        $token = Str::random("60");

        // kayit sirasinda maili dogrulamak icin token olusturup userVerify'a ekliyoruz. daha sonra mail gondertiyoruz
        UserVerify::create([
            'user_id' => $event->user->id,
            'token' => $token
        ]);

        // mail gonderme islemi
        $event->user->notify(new VerifyNotification($token));
        // Mail::to($event->user->email)->send(new VerifyMail($event->user, $token));
    }
}
