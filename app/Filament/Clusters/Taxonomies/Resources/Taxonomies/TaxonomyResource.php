<?php

namespace App\Filament\Clusters\Taxonomies\Resources\Taxonomies;

use App\Filament\Clusters\Taxonomies\Resources\Taxonomies\Schemas\TaxonomyForm;
use App\Filament\Clusters\Taxonomies\Resources\Taxonomies\Tables\TaxonomiesTable;
use App\Filament\Clusters\Taxonomies\TaxonomiesCluster;
use App\Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;

abstract class TaxonomyResource extends Resource
{
    protected static ?string $recordTitleAttribute = 'name';

    protected static ?string $cluster = TaxonomiesCluster::class;

    public static function getNavigationBadge(): ?string
    {
        return (string) static::getEloquentQuery()->count();
    }

    public static function table(Table $table): Table
    {
        return TaxonomiesTable::configure($table);
    }

    public static function form(Schema $schema): Schema
    {
        return TaxonomyForm::configure($schema);
    }
}
