<?php

namespace App\Observers;

use App\Models\User;
use App\Models\UserVerify;
use App\Notifications\PasswordChangedNotification;
use App\Traits\Loggable;
use Illuminate\Support\Str;
use App\Notifications\VerifyNotification;

class UserRegisteredObserver
{
    use Loggable;

    public function __construct()
    {
        $this->model = User::class;
    }

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

        $this->log('create', $user->id, $user->toArray(), $this->model);
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if ($user->wasChanged('password')) {
            $user->notify(new PasswordChangedNotification($user));
        }
        if (!$user->wasChanged('deleted_at')) {
            $this->updateLog($user, $this->model);
        }
    }


    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        $this->log('delete', $user->id, $user->toArray(), $this->model);

    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        $this->log('restore', $user->id, $user->toArray(), $this->model);
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        $this->log('force delete', $user->id, $user->toArray(), $this->model);
    }

}