<?php

namespace App\Filament\Pages;

use BackedEnum;
use Filament\Pages\Dashboard as BaseDashboard;
use Illuminate\Contracts\Support\Htmlable;

class Dashboard extends BaseDashboard
{
    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return 'fas-chart-bar';
    }

    public static function getNavigationLabel(): string
    {
        return __('Dashboard');
    }

    public function getTitle(): string|Htmlable
    {
        return __('Dashboard');
    }

    public function getColumns(): int|array
    {
        return 1;
    }
}
