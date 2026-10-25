<?php

namespace App\Filament\Resources\Users\Pages;

use App\Filament\Concerns\HasAdministrationBreadcrumb;
use App\Filament\Pages\Resources\ListRecords;
use App\Filament\Resources\Users\UserResource;

class ListUsers extends ListRecords
{
    use HasAdministrationBreadcrumb;

    protected static string $resource = UserResource::class;
}
