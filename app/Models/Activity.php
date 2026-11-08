<?php

namespace App\Models;

use App\Models\Contracts\HasActivityLog;
use App\Policies\ActivityPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Activitylog\Models\Activity as BaseActivity;

#[UsePolicy(ActivityPolicy::class)]
class Activity extends BaseActivity
{
    protected static function booted(): void
    {
        static::saving(function (Activity $activity) {
            $user = currentUser();
            $activity->causer_id = $user?->getKey();
            $activity->causer_type = $user ? $user::class : null;
        });
    }

    protected function formattedDescription(): Attribute
    {
        // __('created')
        // __('updated')
        // __('deleted')
        return Attribute::make(function () {
            if (in_array($this->event, ['created', 'deleted'])) {
                return __(':eventName this record', ['eventName' => __($this->event)]);
            }

            if ($this->event === 'updated') {
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
        });
    }
}
