<?php

namespace App\Filament\Commands\FileGenerators\Resources\Pages;

use App\Filament\Pages\Resources\ViewRecord;
use Filament\Commands\FileGenerators\Resources\Pages\ResourceViewRecordPageClassGenerator as BaseResourceViewRecordPageClassGenerator;
use Nette\PhpGenerator\ClassType;

class ResourceViewRecordPageClassGenerator extends BaseResourceViewRecordPageClassGenerator
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
        return ViewRecord::class;
    }

    // do not generate "headerActions" method
    protected function addMethodsToClass(ClassType $class): void {}
}
