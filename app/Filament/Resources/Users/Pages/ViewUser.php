<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Pages\Resources\ViewRecord;
use App\Filament\Resources\Users\UserResource;
use STS\FilamentImpersonate\Actions\Impersonate;

class ViewUser extends ViewRecord
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Impersonate::make(),
        ];
    }
}
