<?php

namespace App\Filament\Clusters\Taxonomies\Resources\Taxonomies\Pages;

use App\Filament\Pages\Resources\ListRecords;
use Filament\Actions\Action;
use Filament\Resources\Resource;

class ListTaxonomies extends ListRecords
{
    // have to force redirect to update a tree
    public function getDefaultActionSuccessRedirectUrl(Action $action): ?string
    {
        /** @var class-string<Resource> $resource */
        $resource = $this->getResource();

        return $resource::getUrl('index');
    }
}
