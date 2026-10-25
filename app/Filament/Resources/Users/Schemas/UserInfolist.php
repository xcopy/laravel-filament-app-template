<?php

namespace App\Filament\Resources\Users\Schemas;

use App\Filament\Schemas\Components\TimestampsGrid;
use App\Filament\Schemas\Components\UserstampsGrid;
use Filament\Infolists\Components\IconEntry;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class UserInfolist
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()->schema([
                    Grid::make(['md' => 2])->schema([
                        TextEntry::make('last_name')
                            ->label(__('Last Name')),
                        TextEntry::make('first_name')
                            ->label(__('First Name')),

                    ]),
                    Grid::make(['md' => 2])->schema([
                        TextEntry::make('email')
                            ->label(__('Email')),
                        TextEntry::make('email_verified_at')
                            ->label(__('Email Verified'))
                            ->dateTime(),
                    ]),
                    Grid::make(['md' => 2])->schema([
                        IconEntry::make('is_active')
                            ->label(__('Active'))
                            ->boolean()
                            ->columnSpan(1),
                        IconEntry::make('has_email_authentication')
                            ->label(__('2FA'))
                            ->boolean()
                            ->columnSpan(1),
                    ]),
                    TextEntry::make('roles.name')
                        ->label(__('Roles'))
                        ->badge()
                        ->separator(', '),
                ]),
                Section::make()->schema([
                    TimestampsGrid::make($schema),
                    UserstampsGrid::make($schema),
                ]),
            ]);
    }
}
