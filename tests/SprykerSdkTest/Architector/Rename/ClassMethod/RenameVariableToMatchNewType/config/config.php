<?php declare(strict_types = 1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\ClassMethod\RenameVariableToMatchNewTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RenameVariableToMatchNewTypeRector::class);
};
