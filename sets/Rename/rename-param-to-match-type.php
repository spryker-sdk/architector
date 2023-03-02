<?php
/**
 * Copyright © 2021-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types = 1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\RenameParamToMatchTypeRector;
use SprykerSdk\Architector\Rename\ClassMethod\RenameVariableToMatchNewTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RenameParamToMatchTypeRector::class);
    $rectorConfig->rule(RenameVariableToMatchNewTypeRector::class);
};
