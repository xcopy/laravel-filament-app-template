<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AuditSection
{
    public static function make(Schema $schema)
    {
        return Section::make()
            ->schema([
                TimestampsGrid::make($schema),
                UserstampsGrid::make($schema),
            ]);
    }
}
