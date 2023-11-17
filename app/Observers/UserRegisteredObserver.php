<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserVerify;
use Illuminate\Support\Str;
use App\Notifications\VerifyNotification;

class UserRegisteredObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function created(User $user)
    {
        $token = Str::random("60");

        // kayit sirasinda maili dogrulamak icin token olusturup userVerify'a ekliyoruz. daha sonra mail gondertiyoruz
        UserVerify::create([
            'user_id' => $user->id,
            'token' => $token
        ]);

        $user->notify(new VerifyNotification($token));
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}