<?php

namespace App\Filament\Schemas\Components;

use App\Filament\Schemas\Components\Concerns\HasVisibilityCondition;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;
use Jenishev\Filament\Infolists\Components\TimestampEntry;

class TimestampsGrid
{
    use HasVisibilityCondition;

    public static function make(Schema $schema): Grid
    {
        $modelClass = $schema->getModel();
        $columns = 2;

        $components = [
            TimestampEntry::make('created_at')
                ->label(__('Created At')),
            TimestampEntry::make('updated_at')
                ->label(__('Updated At')),
        ];

        if (method_exists($modelClass, 'isSoftDeletable') && $modelClass::isSoftDeletable()) {
            $components[] = TimestampEntry::make('deleted_at')
                ->label(__('Deleted At'))
                ->visible(self::getVisibilityCondition($columns));
        }

        return Grid::make($columns)
            ->schema($components)
            ->columns(['default' => $columns]);
    }
}
