<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\PasswordReset\RequestPasswordReset as BaseRequestPasswordReset;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;

class RequestPasswordReset extends BaseRequestPasswordReset
{
    protected function getCredentialsFromFormData(array $data): array
    {
        $data = parent::getCredentialsFromFormData($data);
        $data['is_active'] = true;

        return $data;
    }

    protected function getEmailFormComponent(): Component
    {
        /** @var TextInput $component */
        $component = parent::getEmailFormComponent();

        $component
            ->type('email')
            ->default(request()->query('email'))
            ->readonly(request()->query('signature') && request()->hasValidSignature());

        return $component;
    }

    public function content(Schema $schema): Schema
    {
        if (request()->query('signature') && ! request()->hasValidSignature()) {
            abort(401);
        }

        return parent::content($schema);
    }
}
