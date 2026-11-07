<?php

namespace App\Filament\Clusters\Taxonomies\Resources\Taxonomies\Schemas;

use App\Filament\Forms\Components\NameInput;
use App\Models\Taxonomy;
use Closure;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Illuminate\Database\Eloquent\Model;
use Jenishev\Filament\Forms\Components\DescriptionTextarea;

class TaxonomyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make()
                    ->schema(static::getChildComponents($schema))
                    ->columnSpanFull(),
            ]);
    }

    public static function getChildComponents(Schema $schema)
    {
        /** @var class-string<Taxonomy>|null $model */
        $model = $schema->getModel();

        return [
            NameInput::make()
                ->label(__('Taxonomy Name'))
                ->rules([
                    fn (Get $get, ?Model $record) => function (string $attribute, mixed $value, Closure $fail) use ($model, $get, $record) {
                        $parentId = $get('parent_id');

                        $exists = Taxonomy::query()
                            ->withoutGlobalScopes()
                            ->where('type', $model::taxonomyType())
                            ->where('name', $value)
                            ->when(filled($parentId), fn ($query) => $query->where('parent_id', $parentId))
                            ->when($record, fn ($query) => $query->whereKeyNot($record->getKey()))
                            ->exists();

                        if ($exists) {
                            $fail(__('This taxonomy name is already been taken.'));
                        }
                    },
                ]),
            DescriptionTextarea::make(),
        ];
    }
}
