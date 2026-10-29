<?php

namespace App\Enums;

use Jenishev\Laravel\Support\Enums\Concerns\HasChoices;
use Jenishev\Laravel\Support\Enums\Concerns\HasLabels;
use Jenishev\Laravel\Support\Enums\Concerns\HasValues;

enum AddressTypes: string
{
    use HasChoices;
    use HasLabels;
    use HasValues;

    case Billing = 'billing';
    case Home = 'home';
    case Mailing = 'mailing';
    case Other = 'other';
    case Shipping = 'shipping';
    case Work = 'work';

    public function label(): string
    {
        return match ($this) {
            self::Billing => __('Billing Address'),
            self::Home => __('Home Address'),
            self::Mailing => __('Mailing Address'),
            self::Other => __('Other Address'),
            self::Shipping => __('Shipping Address'),
            self::Work => __('Work Address'),
        };
    }
}
