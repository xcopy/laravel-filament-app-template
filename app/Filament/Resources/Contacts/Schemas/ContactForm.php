<?php

namespace App\Filament\Resources\Contacts\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Jenishev\Laravel\Contacts\Enums\ContactTypes;

// __('Phone')
// __('Other')
class ContactForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Grid::make(['md' => 2])->schema([
                        Select::make('type')
                            ->label(__('Type'))
                            ->options(ContactTypes::choices())
                            ->default(ContactTypes::Phone)
                            ->required(),
                        TextInput::make('value')
                            ->label(__('Value'))
                            ->required(),
                    ]),
                    Grid::make(['md' => 2])->schema([
                        Toggle::make('is_primary')
                            ->label(__('Primary'))
                            ->required(),
                        Toggle::make('is_verified')
                            ->label(__('Verified'))
                            ->required(),
                    ]),
                ])->columnSpanFull(),
            ]);
    }
}
