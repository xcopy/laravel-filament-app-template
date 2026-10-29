<?php

namespace App\Models\Contracts;

use Illuminate\Database\Eloquent\Relations\MorphMany;

interface HasActivityLog
{
    public function activities(): MorphMany;

    public static function getAttributeLabels(): array;

    public static function getAttributeLabel(string $attribute): string;

    public static function getAttributeDisplayValue(string $attribute, mixed $value): ?string;
}
