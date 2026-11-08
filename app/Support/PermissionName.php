<?php

namespace App\Support;

final class PermissionName
{
    /** @param  class-string|object  $model */
    public static function make(string $action, string|object $model): string
    {
        $config = config('filament-shield.permissions');

        $subject = class_basename(is_object($model) ? $model::class : $model);

        return sprintf(
            '%s%s%s',
            str($action)->{$config['case']}(),
            $config['separator'],
            str($subject)->{$config['case']}(),
        );
    }
}
