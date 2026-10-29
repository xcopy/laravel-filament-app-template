<?php

namespace App\Filament\Resources\Addresses\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Jenishev\Filament\Tables\Columns\EnumColumn;
use Jenishev\Filament\Tables\Columns\IdColumn;
use Jenishev\Filament\Tables\Columns\NameColumn;

class AddressesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IdColumn::make(),
                EnumColumn::make('type')
                    ->label(__('Type'))
                    ->sortable(),
                NameColumn::make('address_line_1')
                    ->label(__('Address'))
                    ->wrap()
                    ->grow(),
                NameColumn::make('city')
                    ->label(__('City')),
                NameColumn::make('postal_code')
                    ->label(__('Postal Code')),
                IconColumn::make('is_primary')
                    ->label(__('Primary'))
                    ->sortable(),
            ])
            ->userstampColumns()
            ->timestampColumns()
            ->headerActions([
                CreateAction::make()->modal(),
            ])
            ->pushRecordActions([
                DeleteAction::make()->iconButton(),
            ]);
    }
}
