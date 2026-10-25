<?php

namespace App\Filament\Clusters\AccessControl\Resources\Users\Pages;

use App\Filament\Clusters\AccessControl\Resources\Users\UserResource;
use App\Filament\Concerns\HasAdministrationBreadcrumb;
use App\Filament\Pages\Resources\ListRecords;

class ListUsers extends ListRecords
{
    use HasAdministrationBreadcrumb;

    protected static string $resource = UserResource::class;
}
