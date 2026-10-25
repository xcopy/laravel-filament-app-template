<?php

namespace App\Filament\Tables\Columns;

use Filament\Tables\Columns\TextColumn;

class UserColumn extends TextColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->searchable(['last_name', 'first_name', 'email']);
        $this->sortable(['last_name']); // last name only!
    }
}
