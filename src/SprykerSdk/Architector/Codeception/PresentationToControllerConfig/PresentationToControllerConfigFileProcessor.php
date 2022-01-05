<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Architector\Codeception\PresentationToControllerConfig;

use Rector\Core\Contract\Processor\FileProcessorInterface;

final class PresentationToControllerConfigFileProcessor implements FileProcessorInterface
{
    /**
     * @var array<\SprykerSdk\Architector\Codeception\PresentationToControllerConfig\PresentationToControllerConfigRectorInterface>
     */
    private $rectors;

    /**
     * @param array<\SprykerSdk\Architector\Codeception\PresentationToControllerConfig\PresentationToControllerConfigRectorInterface> $rectors
     */
    public function __construct(array $rectors)
    {
        $this->rectors = $rectors;
    }

    /**
     * @param \Rector\Core\ValueObject\Application\File $file
     * @param \Rector\Core\ValueObject\Configuration $configuration
     *
     * @return bool
     */
    public function supports($file, $configuration): bool
    {
        $smartFileInfo = $file->getSmartFileInfo();

        return (strpos($smartFileInfo->getFilename(), 'codeception.yml') !== false);
    }

    /**
     * @param \Rector\Core\ValueObject\Application\File $file
     * @param \Rector\Core\ValueObject\Configuration $configuration
     *
     * @return void
     */
    public function process($file, $configuration): void
    {
        foreach ($this->rectors as $rector) {
            $changeFileContent = $rector->transform($file->getFileContent());
            $file->changeFileContent($changeFileContent);
        }
    }

    /**
     * @return array<string>
     */
    public function getSupportedFileExtensions(): array
    {
        return ['yml'];
    }
}
