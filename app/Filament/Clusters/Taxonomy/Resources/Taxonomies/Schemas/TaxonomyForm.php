<?php

namespace App\Filament\Clusters\Taxonomy\Resources\Taxonomies\Schemas;

use App\Filament\Forms\Components\NameInput;
use Filament\Forms\Components\Hidden;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Jenishev\Filament\Forms\Components\DescriptionTextarea;

class TaxonomyForm
{
    public static function configure(Schema $schema, ?string $type): Schema
    {
        return $schema
            ->components([
                Hidden::make('type')->default($type),
                Section::make()->schema([
                    NameInput::make(),
                    DescriptionTextarea::make(),
                ])->columnSpanFull(),
            ]);
    }
}
