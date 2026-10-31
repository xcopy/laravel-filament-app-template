<?php

namespace App\Filament\Schemas\Components;

use Filament\Schemas\Components\View;

class Divider
{
    public static function make()
    {
        return View::make('filament.schemas.components.divider');
    }
}
