<?php

namespace App\Filament\Resources\Contacts;

use App\Filament\Resources\Resource;
use App\Models\Contact;

// __('Contact')
// __('Contacts')
class ContactResource extends Resource
{
    protected static ?string $model = Contact::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static bool $hasPages = false;
}
