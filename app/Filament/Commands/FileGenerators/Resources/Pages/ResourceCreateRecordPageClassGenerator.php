<?php

namespace App\Filament\Commands\FileGenerators\Resources\Pages;

use App\Filament\Pages\Resources\CreateRecord;
use Filament\Commands\FileGenerators\Resources\Pages\ResourceCreateRecordPageClassGenerator as BaseCreateRecordPageClassGenerator;

class ResourceCreateRecordPageClassGenerator extends BaseCreateRecordPageClassGenerator
{
    public function getExtends(): string
    {
        return CreateRecord::class;
    }
}
