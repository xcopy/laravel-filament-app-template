<?php

namespace App\Models\Contracts;

use Illuminate\Database\Query\Builder;

interface HasUsers
{
    public function users(): Builder;
}
