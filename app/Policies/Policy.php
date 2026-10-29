<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;

abstract class Policy
{
    use HandlesAuthorization;

    protected function ability(string $method): string
    {
        $config = config('filament-shield.permissions');

        $separator = $config['separator'];
        $case = $config['case'];

        return sprintf(
            '%s%s%s',
            call_user_func([str($method), $case]),
            $separator,
            call_user_func([str(class_basename(static::class))->remove('Policy'), $case])
        );
    }

    public function viewAny(User $user): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function view(User $user, Model $model): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function create(User $user): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function update(User $user, Model $model): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function delete(User $user, Model $model): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function deleteAny(User $user): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function forceDelete(User $user, Model $model): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function forceDeleteAny(User $user): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function restore(User $user, Model $model): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }

    public function restoreAny(User $user): bool
    {
        return $user->can($this->ability(__FUNCTION__));
    }
}
