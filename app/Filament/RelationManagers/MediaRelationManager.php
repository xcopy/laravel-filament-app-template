<?php

namespace App\Filament\RelationManagers;

use App\Filament\Resources\Media\MediaResource;
use App\Models\Contracts\HasMedia;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class MediaRelationManager extends RelationManager
{
    protected static string $relationship = 'media';

    protected static ?string $relatedResource = MediaResource::class;

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        /** @var Model&HasMedia $ownerRecord */
        return (string) Number::abbreviate($ownerRecord->media()->count());
    }
}
