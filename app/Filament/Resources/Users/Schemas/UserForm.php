<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Forms\Components\NameInput;
use App\Models\User;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Jenishev\Filament\Forms\Components\EmailInput;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        $nameInput = fn (string $name) => NameInput::make($name)
            ->rule([
                function (string $attribute, mixed $value, \Closure $fail) {
                    if (! preg_match('/^[\p{L}\p{M}\s\'.\-]+$/u', $value)) {
                        $fail(__('The :attribute may only contain letters, spaces, apostrophes, periods, and hyphens.'));
                    }
                },
            ]);

        return $schema
            ->components([
                Section::make()->schema([
                    $nameInput('last_name')
                        ->label(__('Last Name')),
                    $nameInput('first_name')
                        ->label(__('First Name')),
                    EmailInput::make()
                        ->live(true)
                        ->afterStateUpdated(function (Set $set, $state) {
                            $set(
                                'email',
                                str($state ?? '')
                                    ->trim()
                                    ->lower()
                                    ->value()
                            );
                        })
                        ->required()
                        ->unique(table: 'users'),
                    Select::make('roles')
                        ->label(__('Roles'))
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->preload()
                        ->visible(fn (?User $record) => ! $record?->isSuperAdmin()),
                    Grid::make(['md' => 2])->schema([
                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->inline(false)
                            ->required()
                            ->default(true),
                        DatePicker::make('email_verified_at')
                            ->label(__('Email Verified')),
                    ]),
                ])->columnSpanFull(),
            ]);
    }
}
