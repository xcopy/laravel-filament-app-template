<?php

namespace App\Filament\Resources\Users\Tables;

use App\Models\Role;
use App\Models\User;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Filters\TrashedFilter;
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
                TextColumn::make('roles.name')
                    ->label(__('Roles'))
                    ->badge()
                    ->separator(', '),
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
                SelectFilter::make('roles')
                    ->label(__('Roles'))
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload()
                    ->indicator(function (array $data) {
                        if ($values = $data['values'] ?? []) {
                            $roles = Role::whereIn('id', $values)
                                ->get()
                                ->map(fn (?Role $role) => $role?->name)
                                ->filter()
                                ->implode(', ');

                            return Indicator::make(__('Roles: :roles', compact('roles')));
                        }

                        return null;
                    }),
                TernaryFilter::make('email_verified_at')
                    ->label(__('Email Verified'))
                    ->nullable(),
                TernaryFilter::make('is_active')
                    ->label(__('Active')),
                TrashedFilter::make(),
            ])
            ->pushRecordActions([
                Impersonate::make()
                    ->iconButton()
                    ->icon('fas-user-secret')
                    ->color('secondary'),
            ]);
    }
}
