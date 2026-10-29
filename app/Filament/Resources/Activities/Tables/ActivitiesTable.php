<?php

namespace App\Filament\Resources\Activities\Tables;

use App\Filament\Tables\Columns\UserstampColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Jenishev\Filament\Tables\Columns\IdColumn;
use Jenishev\Filament\Tables\Columns\TimestampColumn;

class ActivitiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->searchable(false)
            ->columns([
                IdColumn::make(),
                UserstampColumn::make('causer.last_name')
                    ->label(__('Created By'))
                    ->toggleable(false),
                TimestampColumn::make('created_at')
                    ->label(__('Created At'))
                    ->toggleable(false),
                TextColumn::make('formatted_description')
                    ->label(__('Description'))
                    ->grow()
                    ->wrap()
                    ->html(),
            ])
            ->recordActions([])
            ->recordAction(null);
    }
}
