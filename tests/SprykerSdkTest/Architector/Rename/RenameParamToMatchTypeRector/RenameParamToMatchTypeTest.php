<?php declare(strict_types = 1);

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdkTest\Architector\Rename\RenameParamToMatchType;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;
use Symplify\SmartFileSystem\SmartFileInfo;

/**
 * @group SprykerSdkTest
 * @group Architector
 * @group SprykerSdkTest
 * @group RenameParamToMatchType
 * @group RenameParamToMatchTypeTest
 */
class RenameParamToMatchTypeTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData()
     *
     * @param \Symplify\SmartFileSystem\SmartFileInfo $fileInfo
     *
     * @return void
     */
    public function test(SmartFileInfo $fileInfo): void
    {
        $this->doTestFileInfo($fileInfo);
    }

    /**
     * @return Iterator<\Symplify\SmartFileSystem\SmartFileInfo>
     */
    public function provideData(): Iterator
    {
        return $this->yieldFilesFromDirectory(__DIR__ . '/Fixture');
    }

    /**
     * @return string
     */
    public function provideConfigFilePath(): string
    {
        return __DIR__ . '/config/config.php';
    }
}