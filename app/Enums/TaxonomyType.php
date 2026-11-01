<?php

namespace App\Enums;

use Jenishev\Laravel\Support\Enums\Concerns\HasChoices;
use Jenishev\Laravel\Support\Enums\Concerns\HasLabels;
use Jenishev\Laravel\Support\Enums\Concerns\HasValues;

enum TaxonomyType: string
{
    use HasChoices;
    use HasLabels;
    use HasValues;

    // cases
}
