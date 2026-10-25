<?php

namespace App\Filament\Tables\Columns;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserstampColumn extends UserColumn
{
    protected function setUp(): void
    {
        parent::setUp();

        $this->formatStateUsing(function (Model $record) {
            /** @var User|null $user */
            $user = $record->{$this->getRelationshipName($record)};

            return $user?->display_label;
        });

        $this->toggleable();
        $this->toggledHiddenByDefault();
    }
}
