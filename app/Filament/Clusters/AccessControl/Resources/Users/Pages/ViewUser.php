<?php

namespace App\Filament\Clusters\AccessControl\Resources\Users\Pages;

use App\Filament\Clusters\AccessControl\Resources\Users\UserResource;
use App\Filament\Concerns\HasAdministrationBreadcrumb;
use App\Filament\Pages\Resources\ViewRecord;
use STS\FilamentImpersonate\Actions\Impersonate;

class ViewUser extends ViewRecord
{
    use HasAdministrationBreadcrumb;

    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            ...parent::getHeaderActions(),
            Impersonate::make(),
        ];
    }
}
