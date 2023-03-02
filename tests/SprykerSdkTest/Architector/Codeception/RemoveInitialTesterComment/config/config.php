<?php declare(strict_types = 1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Codeception\RemoveInitialTesterComment\RemoveInitialTesterCommentRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(RemoveInitialTesterCommentRector::class);
};
