<?php

namespace App\Listeners;

use App\Models\User;
use Filament\Auth\Events\Registered;
use Filament\Auth\Notifications\VerifyEmail;
use Illuminate\Auth\Events\Login;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class SendEmailVerificationNotification implements ShouldQueue
{
    use InteractsWithQueue;

    public function handle(Registered|Login $event): void
    {
        /** @var User $user */
        $user = match (true) {
            $event instanceof Login => $event->user,
            $event instanceof Registered => $event->getUser(),
        };

        if ($user->hasVerifiedEmail()) {
            return;
        }

        $notification = app(VerifyEmail::class);
        $notification->url = filament()->getVerifyEmailUrl($user);

        $user->notify($notification);
    }
}
