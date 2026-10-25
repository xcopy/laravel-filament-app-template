<?php

namespace App\Filament\Clusters\AccessControl;

use App\Filament\Clusters\Cluster;
use BackedEnum;
use UnitEnum;

class AccessControlCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = 'fas-shield-halved';

    protected static ?string $slug = 'admin/access-control';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Administration');
    }

    public static function getNavigationLabel(): string
    {
        return __('Access Control');
    }
}
