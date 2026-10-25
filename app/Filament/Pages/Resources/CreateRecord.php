<?php

namespace App\Filament\Pages\Resources;

use Filament\Resources\Pages\CreateRecord as BaseCreateRecord;

class CreateRecord extends BaseCreateRecord
{
    public function canCreateAnother(): bool
    {
        return false;
    }
}
