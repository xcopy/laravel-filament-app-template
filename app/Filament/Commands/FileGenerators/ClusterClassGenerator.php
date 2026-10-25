<?php

namespace App\Filament\Commands\FileGenerators;

use App\Filament\Clusters\Cluster;
use Filament\Commands\FileGenerators\ClusterClassGenerator as BaseClusterClassGenerator;

class ClusterClassGenerator extends BaseClusterClassGenerator
{
    public function getExtends(): string
    {
        return Cluster::class;
    }
}
