<?php

namespace App\Filament\Pages\Auth;

use App\Filament\Forms\Components\NameInput;
use App\Rules\PersonNameRule;
use Filament\Auth\Pages\EditProfile as BaseEditProfile;
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
                        NameInput::make('first_name')
                            ->label(__('First Name'))
                            ->rule(new PersonNameRule),
                        NameInput::make('last_name')
                            ->label(__('Last Name'))
                            ->rule(new PersonNameRule),
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
