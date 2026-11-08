<?php

use App\Models\User;
use Illuminate\Support\Facades\Auth;

function currentUser(?string $guard = null): ?User
{
    return Auth::guard($guard)->user();
}
