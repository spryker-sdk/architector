<?php declare(strict_types = 1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\ClassMethod\RenameParamToMatchTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RenameParamToMatchTypeRector::class);
};
