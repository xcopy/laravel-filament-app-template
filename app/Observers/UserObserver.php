<?php

namespace App\Observers;

use App\Models\User;
use Illuminate\Contracts\Events\ShouldHandleEventsAfterCommit;
use Illuminate\Support\Str;

class UserObserver implements ShouldHandleEventsAfterCommit
{
    public function creating(User $user): void
    {
        $user->password ??= Str::random(8);
    }
}
