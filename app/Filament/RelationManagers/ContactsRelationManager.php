<?php

namespace App\Filament\RelationManagers;

use App\Filament\Resources\Contacts\ContactResource;
use Filament\Resources\RelationManagers\RelationManager;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Number;
use Jenishev\Laravel\Contacts\Contracts\Contactable;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    protected static ?string $relatedResource = ContactResource::class;

    public static function getBadge(Model $ownerRecord, string $pageClass): ?string
    {
        /** @var Model&Contactable $ownerRecord */
        return (string) Number::abbreviate($ownerRecord->contacts()->count());
    }
}
