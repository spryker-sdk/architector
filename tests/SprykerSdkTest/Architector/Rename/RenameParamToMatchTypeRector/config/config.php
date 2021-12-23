<?php declare(strict_types = 1);

use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use SprykerSdk\Architector\Rename\RenameParamToMatchTypeRector;

return static function (
    ContainerConfigurator $containerConfigurator
): void {
    $services = $containerConfigurator->services();
    $services->set(RenameParamToMatchTypeRector::class);
};
