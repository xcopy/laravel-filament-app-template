<?php

namespace App\Filament\Clusters\Taxonomy;

use App\Filament\Clusters\Cluster;
use BackedEnum;
use UnitEnum;

class TaxonomyCluster extends Cluster
{
    protected static string|BackedEnum|null $navigationIcon = 'fas-list';

    protected static ?string $slug = 'admin/taxonomy';

    public static function getNavigationGroup(): string|UnitEnum|null
    {
        return __('Administration');
    }

    public static function getNavigationLabel(): string
    {
        return __('Taxonomies');
    }
}
