<?php

namespace App\Filament\Concerns;

trait HasAdministrationBreadcrumb
{
    public function getBreadcrumbs(): array
    {
        return [
            '#' => __('Administration'),
            ...parent::getBreadcrumbs(),
        ];
    }
}
