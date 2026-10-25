<?php

namespace App\Filament\Schemas\Components;

use App\Filament\Schemas\Components\Concerns\HasVisibilityCondition;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Grid;
use Filament\Schemas\Schema;

class UserstampsGrid
{
    use HasVisibilityCondition;

    public static function make(Schema $schema): Grid
    {
        $modelClass = $schema->getModel();
        $columns = 2;

        $components = [
            TextEntry::make('creator.display_label')
                ->label(__('Created By')),
            TextEntry::make('editor.display_label')
                ->label(__('Updated By')),
        ];

        if (method_exists($modelClass, 'isSoftDeletable') && $modelClass::isSoftDeletable()) {
            $components[] = TextEntry::make('destroyer.display_label')
                ->label(__('Deleted By'))
                ->visible(self::getVisibilityCondition($columns));
        }

        return Grid::make($columns)
            ->schema($components)
            ->columns(['default' => $columns]);
    }
}
