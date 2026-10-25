<?php

declare(strict_types=1);

namespace App\Policies;

use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Foundation\Auth\User as AuthUser;

class RolePolicy
{
    use HandlesAuthorization;

    public function view(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('view:role');
    }

    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('view-any:role');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('create:role');
    }

    public function update(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('update:role');
    }

    public function delete(AuthUser $authUser, Role $role): bool
    {
        return $authUser->can('delete:role');
    }

    public function deleteAny(AuthUser $authUser): bool
    {
        return $authUser->can('delete-any:role');
    }
}
