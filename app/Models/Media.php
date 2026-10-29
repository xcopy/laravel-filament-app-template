<?php

namespace App\Models;

use App\Models\Contracts\Blameable;
use App\Models\Contracts\SoftDeletable;
use App\Observers\MediaObserver;
use App\Policies\MediaPolicy;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Spatie\MediaLibrary\MediaCollections\Models\Media as BaseMedia;

#[ObservedBy(MediaObserver::class)]
#[UsePolicy(MediaPolicy::class)]
class Media extends BaseMedia implements Blameable, SoftDeletable
{
    use SoftDeletes;
    use Userstamps;
}
