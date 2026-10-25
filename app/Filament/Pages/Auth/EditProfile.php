<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class EditProfile extends BaseEditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema([
                        TextInput::make('first_name')
                            ->label(__('First name'))
                            ->live(true)
                            ->required()
                            ->minLength(3)
                            ->maxLength(50),
                        TextInput::make('last_name')
                            ->label(__('Last name'))
                            ->live(true)
                            ->required()
                            ->minLength(3)
                            ->maxLength(50),
                        $this->getEmailFormComponent(),
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ]),
            ]);
    }

    protected function getRedirectUrl(): ?string
    {
        return filament()->getProfileUrl();
    }
}
