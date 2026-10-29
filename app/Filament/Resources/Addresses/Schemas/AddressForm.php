<?php

namespace App\Filament\Resources\Addresses\Schemas;

use App\Enums\AddressTypes;
use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AddressForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Grid::make(['md' => 2])->schema([
                        Select::make('type')
                            ->label(__('Type'))
                            ->required()
                            ->options(AddressTypes::choices()),
                        Toggle::make('is_primary')
                            ->label(__('Primary'))
                            ->required()
                            ->inline(false),
                    ]),
                    Grid::make(['md' => 2])->schema([
                        TextInput::make('city')
                            ->label(__('City'))
                            ->required()
                            ->default(config('addresses.default_city'))
                            ->maxLength(20),
                        TextInput::make('postal_code')
                            ->label(__('Postal Code'))
                            ->integer()
                            ->maxLength(6),
                    ]),
                    TextInput::make('address_line_1')
                        ->label(__('Address'))
                        ->required(),
                    Hidden::make('country_code')
                        ->required()
                        ->default(config('addresses.default_country_code')),
                ])->columnSpanFull(),
            ]);
    }
}
