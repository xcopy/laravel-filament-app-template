<?php

namespace App\Filament\Clusters\Taxonomy\Resources\Taxonomies;

use App\Filament\Clusters\Taxonomy\Resources\Taxonomies\Schemas\TaxonomyForm;
use App\Filament\Clusters\Taxonomy\Resources\Taxonomies\Tables\TaxonomiesTable;
use App\Filament\Resources\Resource;
use App\Models\Taxonomy;
use BackedEnum;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

abstract class TaxonomyResource extends Resource
{
    protected static ?string $model = Taxonomy::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string|BackedEnum|null $type = null;

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
        return TaxonomyForm::configure($schema, static::$type);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->where('type', static::$type);
    }
}
