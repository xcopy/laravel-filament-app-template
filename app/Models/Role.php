<?php

namespace App\Models;

use App\Policies\RolePolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Spatie\Permission\Models\Role as BaseRole;

#[UsePolicy(RolePolicy::class)]
class Role extends BaseRole
{
    protected $attributes = [
        'guard_name' => 'web',
    ];

    protected function translatedName(): Attribute
    {
        return Attribute::make(
            get: fn () => __(str($this->name)->headline()->value())
        );
    }
}
