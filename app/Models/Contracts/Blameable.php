<?php

namespace App\Models\Contracts;

interface Blameable
{
    public function creator(): mixed;

    public function editor(): mixed;

    public function destroyer(): mixed;
}
