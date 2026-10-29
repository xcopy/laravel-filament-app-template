<?php

namespace App\Filament\RelationManagers;

use App\Filament\Resources\Users\UserResource;
use App\Models\Contracts\HasUsers;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class UsersRelationManager extends RelationManager
{
    protected static string $relationship = 'users';

    protected static ?string $relatedResource = UserResource::class;

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        /** @var Model&HasUsers $ownerRecord */
        return (string) Number::abbreviate($ownerRecord->users()->count());
    }
}
