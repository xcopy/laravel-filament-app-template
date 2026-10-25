<?php

namespace App\Filament\Pages\Resources;

use Filament\Actions\EditAction;
use Filament\Resources\Pages\ViewRecord as BaseViewRecord;

class ViewRecord extends BaseViewRecord
{
    protected function getHeaderActions(): array
    {
        return [
            EditAction::make(),
        ];
    }
}
