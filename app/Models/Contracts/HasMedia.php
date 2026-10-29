<?php

namespace App\Models\Contracts;

use Illuminate\Support\Collection;
use Spatie\MediaLibrary\HasMedia as BaseHasMedia;

interface HasMedia extends BaseHasMedia
{
    public function getRegisteredMediaCollections(): Collection;
}
