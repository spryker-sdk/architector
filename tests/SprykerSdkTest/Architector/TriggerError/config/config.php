<?php declare(strict_types = 1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\TriggerError\TriggerErrorMessagesWithSprykerPrefixRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->rule(TriggerErrorMessagesWithSprykerPrefixRector::class);
};
