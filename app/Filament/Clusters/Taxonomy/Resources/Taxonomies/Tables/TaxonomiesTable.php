<?php

namespace App\Filament\Clusters\Taxonomy\Resources\Taxonomies\Tables;

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
            ->columns([
                IdColumn::make(),
                NameColumn::make()->grow(),
                NameColumn::make('description')
                    ->label(__('Description')),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->userstampColumns()
            ->timestampColumns()
            ->pushRecordActions([
                DeleteAction::make()->iconButton(),
            ]);
    }
}
