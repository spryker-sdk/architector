# Architector
[![CI](https://github.com/spryker-sdk/architector/workflows/CI/badge.svg?branch=master)](https://github.com/spryker-sdk/architector/actions?query=workflow%3ACI+branch%3Amaster)
[![Latest Stable Version](https://poser.pugx.org/spryker-sdk/architector/v/stable.svg)](https://packagist.org/packages/spryker-sdk/architector)
[![Minimum PHP Version](https://img.shields.io/badge/php-%3E%3D%207.4-8892BF.svg)](https://php.net/)
[![PHPStan](https://img.shields.io/badge/PHPStan-enabled-brightgreen.svg?style=flat)](https://github.com/phpstan/phpstan)

## Installation

```
composer require --dev spryker-sdk/architector
```

This is a development only "require-dev" library. Please make sure you include it as such.

### What is the Architector

The Architector is a tool that supports you in automated refactorings regarding Spryker architecture and reports issues in your code.

See [current rules](docs/rules_overview.md) for details.

### Configuration

```
architector.php
```

```
<?php

use Rector\Config\RectorConfig;
use Rector\Set\ValueObject\SetList;
use Architector\Set\ValueObject\ArchitectorSetList;

return static function (RectorConfig $rectorConfig) {
    // Import RuleSets provided by Rector or by the Architector
    $rectorConfig->import(SetList::DEAD_CODE);
    $rectorConfig->import(SetList::EARLY_RETURN);
    $rectorConfig->import(SetList::PHP_74);
    $rectorConfig->import(SetList::NAMING);
    $rectorConfig->import(ArchitectorSetList::RENAME);
    $rectorConfig->import(ArchitectorSetList::CODECEPTION);

    // Defining rules or paths to skip
    $rectorConfig->skip([
        RuleClassNameToSkip::class,
        __DIR__ . '/src/Path/To/Exclude/Something.php',
    ]);
};

```

### How to use the Architector

You can run the Architector in two ways

```
vendor/bin/rector process path/to/refactor --config architector.php
```
or
```
vendor/bin/rector process path/to/refactor --config architector.php --dry-run
```
The latter one only shows a diff without actually changing your code.


For more details see documentation of `vendor/bin/rector`



### How to generate documentation

Run `composer docs` to generate documentation in `docs/rules_overview.md`.
