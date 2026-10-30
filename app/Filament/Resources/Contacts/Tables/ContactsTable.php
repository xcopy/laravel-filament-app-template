<?php

namespace App\Filament\Resources\Contacts\Tables;

use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Table;
use Jenishev\Filament\Tables\Columns\EnumColumn;
use Jenishev\Filament\Tables\Columns\IdColumn;
use Jenishev\Filament\Tables\Columns\NameColumn;

class ContactsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IdColumn::make(),
                EnumColumn::make('type')
                    ->label(__('Type')),
                NameColumn::make('value')
                    ->label(__('Value'))
                    ->grow(),
                IconColumn::make('is_primary')
                    ->label(__('Primary'))
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_verified')
                    ->label(__('Verified'))
                    ->boolean()
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
