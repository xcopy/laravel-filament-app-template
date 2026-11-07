<?php

namespace App\Filament\Clusters\Taxonomies;

use App\Filament\Clusters\Cluster;
use BackedEnum;

class TaxonomiesCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = 'fas-list';

    public static function getNavigationLabel(): string
    {
        return __('Taxonomies');
    }
}
