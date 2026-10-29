<?php

namespace App\Models;

use App\Models\Contracts\Blameable;
use App\Models\Contracts\SoftDeletable;
use App\Policies\ContactPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Jenishev\Laravel\Contacts\Models\Contact as BaseContact;
use Mattiverse\Userstamps\Traits\Userstamps;

#[UsePolicy(ContactPolicy::class)]
class Contact extends BaseContact implements Blameable, SoftDeletable
{
    use SoftDeletes;
    use Userstamps;
}
