<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\User;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Jenishev\Filament\Tables\Columns\IdColumn;
use Jenishev\Filament\Tables\Columns\NameColumn;
use STS\FilamentImpersonate\Actions\Impersonate;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                IdColumn::make(),
                NameColumn::make('last_name')
                    ->label(__('Last Name')),
                NameColumn::make('first_name')
                    ->label(__('First Name')),
                TextColumn::make('email')
                    ->label(__('Email'))
                    ->searchable()
                    ->sortable(),
                IconColumn::make('email_verified_at')
                    ->label(__('Email Verified'))
                    ->getStateUsing(fn (User $record) => $record->hasVerifiedEmail())
                    ->boolean()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label(__('Active'))
                    ->boolean()
                    ->sortable(),
            ])
            ->userstampColumns()
            ->timestampColumns()
            ->filters([
                TernaryFilter::make('email_verified_at')
                    ->label(__('Email Verified'))
                    ->nullable(),
                TernaryFilter::make('is_active')
                    ->label(__('Active')),
            ])
            ->pushRecordActions([
                Impersonate::make()
                    ->iconButton()
                    ->icon('fas-user-secret')
                    ->color('secondary'),
            ]);
    }
}
