<?php

namespace App\Filament\Pages\Auth;

use App\Models\User;
use Filament\Auth\Pages\Login as BaseLogin;
use Filament\Forms\Components\Select;
use Filament\Schemas\Components\Component;
use SensitiveParameter;

class Login extends BaseLogin
{
    protected function getCredentialsFromFormData(#[SensitiveParameter] array $data): array
    {
        $data = parent::getCredentialsFromFormData($data);
        $data['is_active'] = true;

        return $data;
    }

    protected function getEmailFormComponent(): Component
    {
        if (app()->isLocal()) {
            $emails = User::pluck('email')->all();

            return Select::make('email')
                ->label(__('Email'))
                ->options(array_combine($emails, $emails))
                ->required()
                ->default(config('filament.superadmin.email'));
        }

        return parent::getEmailFormComponent();
    }

    protected function getPasswordFormComponent(): Component
    {
        return parent::getPasswordFormComponent()
            ->default(app()->isLocal() ? config('filament.superadmin.password') : null);
    }

    protected function getRememberFormComponent(): Component
    {
        return parent::getRememberFormComponent()
            ->default(app()->isLocal());
    }
}
