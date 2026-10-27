<?php

namespace App\Models;

use Aliziodev\LaravelTaxonomy\Models\Taxonomy as BaseTaxonomy;
use App\Models\Contracts\SoftDeletable;
use App\Policies\TaxonomyPolicy;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;

#[UsePolicy(TaxonomyPolicy::class)]
class Taxonomy extends BaseTaxonomy implements SoftDeletable
{
    use SoftDeletes;
    use Userstamps;
}
