<?php

namespace App\Filament\Forms\Components;

use Jenishev\Filament\Forms\Components\NameInput as BaseNameInput;

class NameInput extends BaseNameInput
{
    protected function setUp(): void
    {
        parent::setUp();

        $this
            ->live(true)
            ->required()
            ->minLength(1)
            ->maxLength(50);
    }
}
