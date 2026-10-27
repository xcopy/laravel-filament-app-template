<?php

namespace App\Filament\Commands\FileGenerators\Resources\Pages;

use App\Filament\Pages\Resources\ListRecords;
use Filament\Commands\FileGenerators\Resources\Pages\ResourceListRecordsPageClassGenerator as BaseResourceListRecordsPageClassGenerator;
use Nette\PhpGenerator\ClassType;

class ResourceListRecordsPageClassGenerator extends BaseResourceListRecordsPageClassGenerator
{
    public function getImports(): array
    {
        $extends = $this->getExtends();
        $extendsBasename = class_basename($extends);

        return [
            $this->getResourceFqn(),
            ...(($extendsBasename === class_basename($this->getFqn())) ? [$extends => "Base{$extendsBasename}"] : [$extends]),
        ];
    }

    public function getExtends(): string
    {
        return ListRecords::class;
    }

    // do not generate "headerActions" method
    protected function addMethodsToClass(ClassType $class): void {}
}
