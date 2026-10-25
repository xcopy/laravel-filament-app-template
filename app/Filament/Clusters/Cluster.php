<?php

namespace App\Filament\Clusters;

use Filament\Clusters\Cluster as BaseCluster;
use Filament\Pages\Enums\SubNavigationPosition;

abstract class Cluster extends BaseCluster
{
    protected static ?SubNavigationPosition $subNavigationPosition = SubNavigationPosition::Top;

    public static function getClusterBreadcrumb(): ?string
    {
        return static::getNavigationLabel();
    }
}
