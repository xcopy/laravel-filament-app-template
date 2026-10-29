<?php

namespace App\Models;

use Addresses\Models\Address as BaseAddress;
use App\Enums\AddressTypes;
use App\Models\Contracts\Blameable;
use App\Models\Contracts\SoftDeletable;
use App\Policies\AddressPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenishev\Laravel\Support\Eloquent\Casts\AsTrimmedString;
use Mattiverse\Userstamps\Traits\Userstamps;

#[UsePolicy(AddressPolicy::class)]
class Address extends BaseAddress implements Blameable, SoftDeletable
{
    use SoftDeletes;
    use Userstamps;

    protected function casts(): array
    {
        return array_merge(
            parent::casts(),
            [
                'type' => AddressTypes::class,
                'address_line_1' => AsTrimmedString::class,
                'address_line_2' => AsTrimmedString::class,
                'city' => AsTrimmedString::class,
                'postal_code' => AsTrimmedString::class,
            ]
        );
    }
}
