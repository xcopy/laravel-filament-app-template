<?php

namespace App\Models;

use App\Models\Contracts\HasActivityLog;
use App\Policies\ActivityPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity as BaseActivity;

#[UsePolicy(ActivityPolicy::class)]
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

    // __('created')
    // __('updated')
    // __('deleted')
    public function getFormattedDescriptionAttribute(): string
    {
        if (in_array($this->event, ['created', 'deleted'])) {
            return __(':eventName this record', ['eventName' => __($this->event)]);
        } elseif ($this->event === 'updated') {
            $changes = $this->changes();

            if (blank($changes['attributes'])) {
                return $this->description;
            }

            /** @var class-string<HasActivityLog> $model */
            $model = $this->subject_type;

            $lines = collect($changes['attributes'])
                ->map(function ($new, $attribute) use ($changes, $model) {
                    $rawOld = $changes['old'][$attribute] ?? null;

                    $old = $rawOld ? $model::getAttributeDisplayValue($attribute, $rawOld) : '?';
                    $new = $model::getAttributeDisplayValue($attribute, $new) ?? '?';

                    return sprintf(
                        '<li>- %s: "%s" → "%s"</li>',
                        $model::getAttributeLabel($attribute),
                        str($old)->limit(),
                        str($new)->limit()
                    );
                })
                ->implode("\n");

            return __('updated') . ":\n" . "<ul>\n$lines\n</ul>";
        }

        return $this->description;
    }
}
