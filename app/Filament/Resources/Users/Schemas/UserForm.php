<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Forms\Components\NameInput;
use Filament\Forms\Components\Toggle;
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
                    Toggle::make('is_active')
                        ->label(__('Active'))
                        ->inline(false)
                        ->required()
                        ->default(true),
                ])->columnSpanFull(),
            ]);
    }
}
