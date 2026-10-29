<?php

use App\Enums\AddressTypes;

return [

    /*
    |--------------------------------------------------------------------------
    | Tenancy Mode
    |--------------------------------------------------------------------------
    |
    | Controls how the package handles multi-tenancy.
    | 'auto' - Auto-detect tenancy package presence
    | 'single' - Force single-tenant mode
    | 'multi' - Force multi-tenant mode
    |
    */
    'tenancy_mode' => 'auto',

    /*
    |--------------------------------------------------------------------------
    | Address Types
    |--------------------------------------------------------------------------
    |
    | The list of allowed address types. Used for validation.
    |
    */
    'types' => AddressTypes::values(),

    /*
    |--------------------------------------------------------------------------
    | Default Type
    |--------------------------------------------------------------------------
    |
    | The default address type when none is specified.
    |
    */
    'default_type' => AddressTypes::Work->value,

    /*
    |--------------------------------------------------------------------------
    | Allow Custom Types
    |--------------------------------------------------------------------------
    |
    | When true, types not listed in 'types' array are still accepted.
    | When false, only types in the 'types' array are valid.
    |
    */
    'allow_custom_types' => true,

    'default_city' => env('ADDRESS_DEFAULT_CITY', 'Bishkek'),
    'default_country_code' => env('ADDRESS_DEFAULT_COUNTRY_CODE', 'KG'),

];
