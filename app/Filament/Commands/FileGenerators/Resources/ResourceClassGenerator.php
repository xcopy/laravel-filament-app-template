<?php

namespace App\Filament\Commands\FileGenerators\Resources;

use App\Filament\Resources\Resource;
use Filament\Commands\FileGenerators\Resources\ResourceClassGenerator as BaseResourceClassGenerator;
use Nette\PhpGenerator\ClassType;

class ResourceClassGenerator extends BaseResourceClassGenerator
{
    public function getExtends(): string
    {
        return Resource::class;
    }

    public function getImports(): array
    {
        return [
            Resource::class,
            ...(($this->getModelBasename() === 'Resource') ? [$this->getModelFqn() => 'ResourceModel'] : [$this->getModelFqn()]),
            ...$this->getPagesImports(),
        ];
    }

    protected function addPropertiesToClass(ClassType $class): void
    {
        $this->addModelPropertyToClass($class);
    }

    protected function addMethodsToClass(ClassType $class): void
    {
        $this->addGetPagesMethodToClass($class);
    }
}
