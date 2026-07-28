<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Architector\Codeception\RemoveInitialTesterComment;

use PhpParser\Node;
use PhpParser\Node\Stmt\Nop;
use PhpParser\NodeVisitor;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class RemoveInitialTesterCommentRector extends AbstractRector
{
    /**
     * @return array<class-string<\PhpParser\Node>>
     */
    public function getNodeTypes(): array
    {
        return [Nop::class];
    }

    /**
     * {@inheritDoc}
     */
    public function refactor(Node $node): ?int
    {
        $docComments = $node->getAttribute('comments');

        /** @var \PhpParser\Comment\Doc $docComment */
        foreach ($docComments as $docComment) {
            if (strpos($docComment->getText(), 'Define custom actions here') !== false) {
                return NodeVisitor::REMOVE_NODE;
            }
        }

        return null;
    }

    /**
     * @return \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition(
            'Removes the initial comment in tester classes.',
            [
                new CodeSample(
                    <<<'CODE_SAMPLE'
class SomeTest
{
    use _generated\XPresentationTesterActions;

    /**
     * Define custom actions here
     */
}
CODE_SAMPLE,
                    <<<'CODE_SAMPLE'
class SomeTest
{
    use _generated\XPresentationTesterActions;
}
CODE_SAMPLE,
                ),
            ],
        );
    }
}
