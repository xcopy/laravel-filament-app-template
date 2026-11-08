<?php

namespace App\Policies;

use App\Models\User;
use App\Support\PermissionName;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Database\Eloquent\Model;
use LogicException;

abstract class Policy
{
    use HandlesAuthorization;

    /** @var class-string<Model>|null */
    protected static ?string $model = null;

    /** @var array<class-string, class-string<Model>> */
    private static array $resolved = [];

    /** @return class-string<Model> */
    protected static function guessModel(): string
    {
        $name = str(class_basename(static::class))->beforeLast('Policy')->toString();

        foreach (['App\\Models\\', 'App\\'] as $namespace) {
            if (class_exists($class = $namespace . $name)) {
                return $class;
            }
        }

        throw new LogicException(sprintf(
            'Cannot guess model for policy [%s]. Set protected static ?string $model.',
            static::class,
        ));
    }

    protected function ability(string $method): string
    {
        return PermissionName::make($method, static::model());
    }

    /** @return class-string<Model> */
    public static function model(): string
    {
        if (static::$model !== null) {
            return static::$model;
        }

        return self::$resolved[static::class] ??= static::guessModel();
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
