<?php

namespace App\Filament\Resources\Addresses;

use App\Filament\Resources\Resource;
use App\Models\Address;

// __('Address')
// __('Addresses')
class AddressResource extends Resource
{
    protected static ?string $model = Address::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static bool $hasPages = false;
}
