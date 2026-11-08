<?php

namespace App\Filament\Clusters\Taxonomies\Resources\Taxonomies\Tables;

use Filament\Actions\DeleteAction;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Jenishev\Filament\Tables\Columns\IdColumn;
use Jenishev\Filament\Tables\Columns\NameColumn;

class TaxonomiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns(static::getColumns())
            ->filters(static::getFilters())
            ->userstampColumns()
            ->timestampColumns()
            ->pushRecordActions([
                DeleteAction::make()->iconButton(),
            ]);
    }

    public static function getColumns(): array
    {
        return [
            IdColumn::make(),
            NameColumn::make()
                ->label(__('Taxonomy Name')),
            NameColumn::make('slug')
                ->label('Slug')
                ->visible(currentUser()->isSuperAdmin()),
            NameColumn::make('description')
                ->label(__('Description'))
                ->grow(),
        ];
    }

    public static function getFilters(): array
    {
        return [
            TrashedFilter::make(),
        ];
    }
}
