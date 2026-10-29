<?php

namespace App\Filament\Resources\Media\Pages;

use App\Filament\Pages\Resources\ListRecords;
use App\Filament\Resources\Media\MediaResource;

class ListMedia extends ListRecords
{
    protected static string $resource = MediaResource::class;

    protected function getHeaderActions(): array
    {
        return []; // no actions
    }
}
