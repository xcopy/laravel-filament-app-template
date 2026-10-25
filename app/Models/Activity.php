<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity as BaseActivity;

class Activity extends BaseActivity
{
    protected static function booted(): void
    {
        static::saving(function (Activity $activity) {
            /** @var User $user */
            $user = Auth::user();
            $activity->causer_id = $user?->getKey();
            $activity->causer_type = $user ? get_class($user) : null;
        });
    }
}
