<?php

namespace App\Observers;

use App\Models\User;
use Filament\Auth\Events\Registered;
use Filament\Auth\Notifications\ResetPassword;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class UserObserver implements ShouldHandleEventsAfterCommit
{
    public function creating(User $user): void
    {
        $user->password ??= Str::random(12);
    }

    public function created(User $user): void
    {
        Password::broker(filament()->getAuthPasswordBroker())
            ->sendResetLink(
                ['email' => $user->email],
                function (User $user, string $token) {
                    $notification = app(ResetPassword::class, compact('token'));
                    $notification->url = filament()->getResetPasswordUrl($token, $user);

                    $user->notify($notification);
                }
            );

        event(new Registered($user));
    }
}
