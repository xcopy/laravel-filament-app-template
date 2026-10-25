<?php

namespace App\Models\Contracts;

interface SoftDeletable
{
    /** @return bool */
    public function trashed();
}
