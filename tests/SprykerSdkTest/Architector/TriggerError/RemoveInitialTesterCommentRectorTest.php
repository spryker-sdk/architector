<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace Utils\RectorTest\Codeception\RemoveInitialTesterComment;

use Iterator;
use Rector\Testing\PHPUnit\AbstractRectorTestCase;

class RemoveInitialTesterCommentRectorTest extends AbstractRectorTestCase
{
    /**
     * @dataProvider provideData
     *
     * @param \Symplify\SmartFileSystem\SmartFileInfo|string $fileInfo
     *
     * @return void
     */
    public function test(string $fileInfo): void
    {
        $this->doTestFile($fileInfo);
    }

    /**
     * @return \Iterator<\Symplify\SmartFileSystem\SmartFileInfo>
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
