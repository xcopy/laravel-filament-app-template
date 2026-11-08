<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class UserPolicy extends Policy
{
    public function update(User $user, Model $model): bool
    {
        return parent::update($user, $model) && ! $user->is($model);
    }
}
