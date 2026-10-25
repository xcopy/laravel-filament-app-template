<?php

namespace App\Filament\Resources;

use App\Models\Contracts\SoftDeletable;
use Filament\Resources\Resource as BaseResource;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

abstract class Resource extends BaseResource
{
    protected static bool $hasPages = true;

    public static function getModelLabel(): string
    {
        return __(str(class_basename(static::class))
            ->remove('Resource')
            ->headline()
            ->value());
    }

    public static function getNavigationLabel(): string
    {
        return __(str(class_basename(static::class))
            ->remove('Resource')
            ->pluralPascal()
            ->headline()
            ->value());
    }

    public static function getPluralModelLabel(): string
    {
        return static::getNavigationLabel();
    }

    public static function getTitleCasePluralModelLabel(): string
    {
        return static::getNavigationLabel();
    }

    public static function form(Schema $schema): Schema
    {
        $basename = class_basename(static::getModel());

        /** @var class-string $class */
        $class = str(static::class)
            ->remove(class_basename(static::class))
            ->append("Schemas\\{$basename}Form")
            ->value();

        return class_exists($class)
            ? call_user_func([$class, 'configure'], $schema)
            : $schema;
    }

    public static function infolist(Schema $schema): Schema
    {
        $basename = class_basename(static::getModel());

        /** @var class-string $class */
        $class = str(static::class)
            ->remove(class_basename(static::class))
            ->append("Schemas\\{$basename}Infolist")
            ->value();

        return class_exists($class)
            ? call_user_func([$class, 'configure'], $schema)
            : $schema;
    }

    public static function table(Table $table): Table
    {
        $basename = str(class_basename(static::getModel()))
            ->pluralPascal()
            ->value();

        /** @var class-string $class */
        $class = str(static::class)
            ->remove(class_basename(static::class))
            ->append("Tables\\{$basename}Table")
            ->value();

        return class_exists($class)
            ? call_user_func([$class, 'configure'], $table)
            : $table;
    }

    public static function getRecordRouteBindingEloquentQuery(): Builder
    {
        $recordRouteBindingEloquentQuery = parent::getRecordRouteBindingEloquentQuery();

        if (is_a(static::getModel(), SoftDeletable::class, true)) {
            $recordRouteBindingEloquentQuery
                ->withoutGlobalScopes([
                    SoftDeletingScope::class,
                ]);
        }

        return $recordRouteBindingEloquentQuery;
    }
}
