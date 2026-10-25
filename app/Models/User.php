<?php

namespace App\Models;

use App\Models\Contracts\SoftDeletable;
use App\Observers\UserObserver;
use Database\Factories\UserFactory;
use Filament\Models\Contracts\FilamentUser;
use Filament\Models\Contracts\HasName as HasFilamentName;
use Filament\Panel;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable([
    'first_name',
    'last_name',
    'email',
    'password',
    'is_active',
    'has_email_authentication',
])]
#[Hidden([
    'password',
    'remember_token',
])]
#[UseFactory(UserFactory::class)]
#[ObservedBy(UserObserver::class)]
class User extends Authenticatable implements FilamentUser, HasFilamentName, MustVerifyEmail, SoftDeletable
{
    use HasFactory;
    use HasRoles;
    use Notifiable;
    use SoftDeletes;

    protected $attributes = [
        'is_active' => true,
        'has_email_authentication' => false,
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /** @return Attribute<string, never> */
    protected function fullName(): Attribute
    {
        return Attribute::make(
            get: fn () => sprintf('%s %s', $this->last_name, $this->first_name),
        );
    }

    /** @return Attribute<string, never> */
    protected function displayLabel(): Attribute
    {
        return Attribute::make(
            get: fn () => str($this->first_name)
                ->take(1)
                ->whenNotEmpty(fn ($value) => str($value)->prepend(' ')->append('.'))
                ->prepend($this->last_name)
                ->value()
        );
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $panel->getId() === 'admin';
    }

    public function getFilamentName(): string
    {
        return $this->display_label;
    }

    public function isSuperAdmin(): bool
    {
        return once(fn () => $this->email === config('filament.superadmin.email'));
    }

    public function canImpersonate(): bool
    {
        return $this->isSuperAdmin();
    }

    public function canBeImpersonated(): bool
    {
        return ! $this->isSuperAdmin();
    }
}
