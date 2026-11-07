<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster as BaseCluster;
use Filament\Pages\Enums\SubNavigationPosition;
use Filament\Panel;
use UnitEnum;

abstract class Cluster extends BaseCluster
{
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Start;

    public static function getClusterBreadcrumb(): ?string
    {
        return static::getNavigationLabel();
    }

    public static function getSlug(?Panel $panel = null): string
    {
        return 'admin/' . str(class_basename(static::class))
            ->remove('Cluster')
            ->plural()
            ->kebab()
            ->value();
    }

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Administration');
    }
}
