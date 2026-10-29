<?php

namespace App\Filament\RelationManagers;

use App\Filament\Resources\Activities\ActivityResource;
use App\Models\Contracts\HasActivityLog;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class ActivitiesRelationManager extends RelationManager
{
    protected static string $relationship = 'activities';

    protected static ?string $relatedResource = ActivityResource::class;

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        /** @var Model&HasActivityLog $ownerRecord */
        return (string) Number::abbreviate($ownerRecord->activities()->count());
    }
}
