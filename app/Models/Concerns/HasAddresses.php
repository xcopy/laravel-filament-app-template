<?php

namespace App\Models\Concerns;

use Addresses\Concerns\HasAddresses as BaseHasAddresses;
use App\Models\Address;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait HasAddresses
{
    use BaseHasAddresses;

    // note: rewrite to use local App\Models\Address model
    public function addresses(): MorphMany
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    // note: rewrite to use local App\Models\Address model
    public function primaryAddress(): MorphOne
    {
        return $this->morphOne(Address::class, 'addressable')
            ->where('is_primary', true);
    }
}
