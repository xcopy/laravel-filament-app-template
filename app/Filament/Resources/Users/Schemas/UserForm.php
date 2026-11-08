<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Forms\Components\NameInput;
use App\Models\Role;
use App\Rules\PersonNameRule;
use BezhanSalleh\FilamentShield\Support\Utils;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Support\Enums\Operation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Validation\Rules\Password;
use Jenishev\Filament\Forms\Components\EmailInput;
use Jenishev\Filament\Forms\Components\PasswordInput;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        $nameInput = fn (string $name) => NameInput::make($name)
            ->rule(new PersonNameRule);

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
                    PasswordInput::make()
                        ->revealable(true)
                        ->rule(Password::default())
                        ->required()
                        ->autocomplete('new-password')
                        ->visibleOn(Operation::Create),
                    Select::make('roles')
                        ->label(__('Roles'))
                        ->relationship(
                            'roles',
                            'name',
                            modifyQueryUsing: fn (Builder $query) => $query->whereNot('name', Utils::getSuperAdminName())
                        )
                        ->getOptionLabelFromRecordUsing(fn (Role $record) => $record->translated_name)
                        ->multiple()
                        ->preload(),
                    Grid::make(['md' => 2])->schema([
                        Toggle::make('is_active')
                            ->label(__('Active'))
                            ->inline(false)
                            ->required()
                            ->default(true),
                        DatePicker::make('email_verified_at')
                            ->label(__('Email Verified'))
                            ->default(now()),
                    ]),
                ])->columnSpanFull(),
            ]);
    }
}
