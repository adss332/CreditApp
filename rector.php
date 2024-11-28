<?php

declare(strict_types=1);

use Rector\CodingStyle\Rector\ClassConst\RemoveFinalFromConstRector;
use Rector\CodingStyle\Rector\Encapsed\EncapsedStringsToSprintfRector;
use Rector\Config\RectorConfig;
use Rector\Naming\Rector\Assign\RenameVariableToMatchMethodCallReturnTypeRector;
use Rector\Naming\Rector\Class_\RenamePropertyToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameParamToMatchTypeRector;
use Rector\Naming\Rector\ClassMethod\RenameVariableToMatchNewTypeRector;
use Rector\Php83\Rector\ClassMethod\AddOverrideAttributeToOverriddenMethodsRector;
use Rector\PHPUnit\CodeQuality\Rector\Class_\PreferPHPUnitThisCallRector;
use Rector\PHPUnit\Set\PHPUnitSetList;
use Rector\Symfony\Set\SymfonySetList;

return RectorConfig::configure()
    ->withPaths([
        __DIR__ . '/public',
        __DIR__ . '/src',
    ])
    ->withParallel()
    ->withRootFiles()
    ->withPreparedSets(
        deadCode: true,
        codeQuality: true,
        codingStyle: true,
        typeDeclarations: true,
        privatization: true,
        naming: true,
        instanceOf: true,
        earlyReturn: true,
        rectorPreset: true,
    )
    ->withAttributesSets(
        symfony: true,
        doctrine: true,
        phpunit: true,
    )
    ->withPhpSets(php83: true)
    ->withSets([
        PHPUnitSetList::PHPUNIT_CODE_QUALITY,
        SymfonySetList::CONFIGS,
        SymfonySetList::SYMFONY_CODE_QUALITY,
        SymfonySetList::SYMFONY_CONSTRUCTOR_INJECTION,
    ])
    ->withImportNames()
    ->withSkip([
        AddOverrideAttributeToOverriddenMethodsRector::class,
        EncapsedStringsToSprintfRector::class,
        PreferPHPUnitThisCallRector::class,
        RemoveFinalFromConstRector::class,
        RenameParamToMatchTypeRector::class,
        RenamePropertyToMatchTypeRector::class,
        RenameVariableToMatchMethodCallReturnTypeRector::class,
        RenameVariableToMatchNewTypeRector::class,
    ])
;
