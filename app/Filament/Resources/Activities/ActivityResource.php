<?php

namespace App\Filament\Resources\Activities;

use App\Filament\Resources\Resource;
use App\Models\Activity;

// __('Activity')
// __('Activities')
class ActivityResource extends Resource
{
    protected static ?string $model = Activity::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static bool $hasPages = false;
}
