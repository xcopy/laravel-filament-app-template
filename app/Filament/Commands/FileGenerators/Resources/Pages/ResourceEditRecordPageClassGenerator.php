<?php

namespace App\Filament\Commands\FileGenerators\Resources\Pages;

use App\Filament\Pages\Resources\EditRecord;
use Filament\Commands\FileGenerators\Resources\Pages\ResourceEditRecordPageClassGenerator as BaseEditRecordPageClassGenerator;
use Nette\PhpGenerator\ClassType;

class ResourceEditRecordPageClassGenerator extends BaseEditRecordPageClassGenerator
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
        return EditRecord::class;
    }

    // do not generate "headerActions" method
    protected function addMethodsToClass(ClassType $class): void {}
}
