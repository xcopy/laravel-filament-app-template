<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;

class ActivityPolicy extends Policy
{
    public function update(User $user, Model $model): bool
    {
        return false;
    }
}
