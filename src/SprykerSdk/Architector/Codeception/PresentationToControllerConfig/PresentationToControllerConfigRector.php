<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Architector\Codeception\PresentationToControllerConfig;

use Symfony\Component\Yaml\Yaml;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class PresentationToControllerConfigRector implements PresentationToControllerConfigRectorInterface
{
    /**
     * @var string[]
     */
    private $modulesToAdd = [
        '\SprykerTest\Shared\Testify\Helper\Environment',
        '\SprykerTest\Shared\Testify\Helper\ConfigHelper',
        '\PyzTest\Yves\Testify\Helper\BootstrapHelper',
    ];

    /**
     * @var string[]
     */
    private $modulesToRemove = [
        'Asserts',
        '\PyzTest\Shared\Testify\Helper\Environment',
        'WebDriver',
    ];

    /**
     * @param string $content
     *
     * @return string
     */
    public function transform(string $content): string
    {
        $ymlAsArray = Yaml::parse($content);

        if (!isset($ymlAsArray['suites']['Presentation'])) {
            return $content;
        }

        // Copy config from Presentation to Controller suite
        $ymlAsArray['suites']['Controller'] = $ymlAsArray['suites']['Presentation'];

        // Remove Presentation suite
        unset($ymlAsArray['suites']['Presentation']);

        $ymlAsArray['suites']['Controller']['path'] = 'Controller';
        $ymlAsArray['suites']['Controller']['class_name'] = str_replace('PresentationTester', 'ControllerTester', $ymlAsArray['suites']['Controller']['class_name']);

        $enabledModules = $ymlAsArray['suites']['Controller']['modules']['enabled'];

        foreach ($this->modulesToAdd as $moduleToAdd) {
            if (!in_array($moduleToAdd, $enabledModules)) {
                $enabledModules[] = $moduleToAdd;
            }
        }

        unset($moduleToAdd);

        $filteredEnabledModules = [];

        foreach ($enabledModules as $enabledModule) {
            if (is_array($enabledModule)) {
                foreach ($enabledModule as $key => $configuration) {
                    if (!in_array($key, $this->modulesToRemove)) {
                        $filteredEnabledModules[] = $enabledModule;
                    }
                }

                continue;
            }

            if (!in_array($enabledModule, $this->modulesToRemove)) {
                $filteredEnabledModules[] = $enabledModule;
            }
        }

        $ymlAsArray['suites']['Controller']['modules']['enabled'] = $filteredEnabledModules;

        return Yaml::dump($ymlAsArray);
    }

    /**
     * @return \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Moves configuration from Presentation to Communication tests.',
            []
        );
    }
}
