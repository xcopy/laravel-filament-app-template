<?php

namespace App\Models\Concerns;

use Illuminate\Support\Arr;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity as BaseLogsActivity;

trait LogsActivity
{
    use BaseLogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs()
            ->logExcept([
                'password',
            ])
            ->dontLogIfAttributesChangedOnly([
                'deleted_at',
                'deleted_by',
                'updated_at',
                'updated_by',
            ]);
    }

    public static function getAttributeLabel(string $attribute): string
    {
        return Arr::get(
            static::getAttributeLabels(),
            $attribute,
            str($attribute)
                ->replaceLast('_id', '')
                ->headline()
                ->value()
        );
    }

    public static function getAttributeDisplayValue(string $attribute, mixed $value): ?string
    {
        return $value;
    }
}
