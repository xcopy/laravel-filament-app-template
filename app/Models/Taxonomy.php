<?php

namespace App\Models;

use Aliziodev\LaravelTaxonomy\Models\Taxonomy as BaseTaxonomy;
use App\Models\Contracts\SoftDeletable;
use App\Policies\TaxonomyPolicy;
use BackedEnum;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Mattiverse\Userstamps\Traits\Userstamps;
use Znck\Eloquent\Traits\HasTableAlias;

#[UsePolicy(TaxonomyPolicy::class)]
class Taxonomy extends BaseTaxonomy implements SoftDeletable
{
    use HasTableAlias;
    use SoftDeletes;
    use Userstamps;

    public function __construct(array $attributes = [])
    {
        if (($type = static::taxonomyType()) !== null) {
            $this->attributes['type'] = $type;
        }

        parent::__construct($attributes);
    }

    public function getTable(): string
    {
        return $this->table ?? parent::getTable();
    }

    protected function performInsert(Builder $query): bool
    {
        // Inserts target the physical table, not the table alias used by model queries.
        $query->getQuery()->from(parent::getTable());

        return parent::performInsert($query);
    }

    public static function taxonomyType(): string|BackedEnum|null
    {
        // The base class itself has no type; subclasses guess it from their name
        return static::class === self::class
            ? null
            : str(class_basename(static::class))->kebab()->value();
    }

    protected static function booted(): void
    {
        parent::booted();

        static::addGlobalScope('taxonomy-type', function (Builder $query): void {
            if (($type = static::taxonomyType()) !== null) {
                $query->where($query->qualifyColumn('type'), $type);
            }
        });
    }
}
