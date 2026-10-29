<?php

namespace App\Filament\Forms\Components;

use App\Models\Contracts\HasMedia;
use Filament\Forms\Components\SpatieMediaLibraryFileUpload;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;

class SpatieMediaLibraryFileUploads
{
    /** @param class-string<HasMedia> $model */
    public static function make(string $model): array
    {
        return (new $model)
            ->getRegisteredMediaCollections()
            ->whenEmpty(fn (Collection $c) => $c->push(MediaCollection::create('files')))
            ->map(function (MediaCollection $mediaCollection) {
                $name = $mediaCollection->name;

                return SpatieMediaLibraryFileUpload::make($name)
                    ->label(__(str($name)->headline()->value()))
                    ->collection($name);
            })
            ->all();
    }
}
