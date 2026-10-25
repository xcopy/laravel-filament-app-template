<?php

namespace App\Filament\Schemas\Components\Concerns;

use App\Models\Contracts\SoftDeletable;
use Closure;
use Illuminate\Database\Eloquent\Model;

trait HasVisibilityCondition
{
    protected static function getVisibilityCondition(int &$columns): Closure
    {
        return function (Model $record) use (&$columns): bool {
            /** @var SoftDeletable&Model $record */
            if ($record->trashed()) {
                $columns++;

                return true;
            }

            return false;
        };
    }
}
