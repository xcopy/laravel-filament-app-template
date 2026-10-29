<?php

namespace App\Filament\RelationManagers;

use App\Filament\Resources\Addresses\AddressResource;
use App\Models\Contracts\Addressable;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;

class AddressesRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $relatedResource = AddressResource::class;

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        /** @var Model&Addressable $ownerRecord */
        return (string) Number::abbreviate($ownerRecord->addresses()->count());
    }
}
