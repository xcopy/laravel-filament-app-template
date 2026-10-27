<?php

namespace Database\Seeders;

use App\Models\Taxonomy;
use Illuminate\Database\Seeder;

class TaxonomySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        if (! app()->isLocal()) {
            return;
        }

        foreach (['Red', 'Green', 'Blue', 'Yellow'] as $name) {
            Taxonomy::create([
                'name' => $name,
                'type' => 'color',
            ]);
        }
    }
}
