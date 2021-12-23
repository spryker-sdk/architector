<?php declare(strict_types = 1);

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerSdk\Architector\Rename;

use PhpParser\Node;
use PhpParser\Node\Param;
use PhpParser\Node\Stmt\ClassMethod;
use Rector\Core\Rector\AbstractRector;
use Rector\Core\ValueObject\MethodName;
use Rector\Naming\ExpectedNameResolver\MatchParamTypeExpectedNameResolver;
use Rector\Naming\Guard\BreakingVariableRenameGuard;
use Rector\Naming\Naming\ExpectedNameResolver;
use Rector\Naming\ParamRenamer\ParamRenamer;
use Rector\Naming\ValueObject\ParamRename;
use Rector\Naming\ValueObjectFactory\ParamRenameFactory;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;

class RenameParamToMatchTypeRector extends AbstractRector
{
    /**
     * @var bool
     */
    private $hasChanged = false;

    /**
     * @var \Rector\Naming\Guard\BreakingVariableRenameGuard
     */
    private $breakingVariableRenameGuard;

    /**
     * @var \Rector\Naming\Naming\ExpectedNameResolver
     */
    private $expectedNameResolver;

    /**
     * @var \Rector\Naming\ExpectedNameResolver\MatchParamTypeExpectedNameResolver
     */
    private $matchParamTypeExpectedNameResolver;

    /**
     * @var \Rector\Naming\ValueObjectFactory\ParamRenameFactory
     */
    private $paramRenameFactory;

    /**
     * @var \Rector\Naming\ParamRenamer\ParamRenamer
     */
    private $paramRenamer;

    public function __construct(
        BreakingVariableRenameGuard $breakingVariableRenameGuard,
        ExpectedNameResolver $expectedNameResolver,
        MatchParamTypeExpectedNameResolver $matchParamTypeExpectedNameResolver,
        ParamRenameFactory $paramRenameFactory,
        ParamRenamer $paramRenamer
    ) {
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->expectedNameResolver = $expectedNameResolver;
        $this->matchParamTypeExpectedNameResolver = $matchParamTypeExpectedNameResolver;
        $this->paramRenameFactory = $paramRenameFactory;
        $this->paramRenamer = $paramRenamer;
    }

    /**
     * @return RuleDefinition
     * @throws \Symplify\RuleDocGenerator\Exception\PoorDocumentationException
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Rename param to match ClassType',
            [
                new CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(FooBarTransfer $fooBar)
    {
        $foo = $fooBar;
    }
}
CODE_SAMPLE
                    , <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(FooBarTransfer $fooBarTransfer)
    {
        $foo = $fooBarTransfer;
    }
}
CODE_SAMPLE
                ),
                new CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(SpyFooBar $fooBar)
    {
        $foo = $fooBar;
    }
}
CODE_SAMPLE
                    , <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(SpyFooBar $fooBarEntity)
    {
        $foo = $fooBarEntity;
    }
}
CODE_SAMPLE
                ),
                new CodeSample(<<<'CODE_SAMPLE'
class SomeClass
{
    public function run(SpyFooBarQuery $fooBar)
    {
        $foo = $fooBar;
    }
}
CODE_SAMPLE
                    , <<<'CODE_SAMPLE'
class SomeClass
{
    public function run(SpyFooBarQuery $fooBarQuery)
    {
        $foo = $fooBarQuery;
    }
}
CODE_SAMPLE
                ),
            ]
        );
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $node
     */
    public function refactor(Node $node): ?Node
    {
        $this->hasChanged = \false;

        foreach ($node->params as $param) {
            $expectedName = $this->expectedNameResolver->resolveForParamIfNotYet($param);
            $expectedName = $this->getExpectedName($expectedName);

            if ($expectedName === null) {
                continue;
            }

            if ($this->shouldSkipParam($param, $expectedName, $node)) {
                continue;
            }

            $expectedName = $this->matchParamTypeExpectedNameResolver->resolve($param);
            $expectedName = $this->getExpectedName($expectedName);

            if ($expectedName === null) {
                continue;
            }

            $paramRename = $this->paramRenameFactory->createFromResolvedExpectedName($param, $expectedName);

            if (!$paramRename instanceof ParamRename) {
                continue;
            }

            $this->paramRenamer->rename($paramRename);
            $this->hasChanged = \true;
        }
        if (!$this->hasChanged) {
            return null;
        }

        return $node;
    }

    /**
     * @param string $expectedName
     *
     * @return string
     */
    protected function getExpectedName(string $expectedName): string
    {
        // Propel Query
        if (preg_match('/^spy[a-zA-Z]+Query/', $expectedName)) {
            return lcfirst(ltrim($expectedName, 'spy'));
        }

        // Propel Entity
        if (preg_match('/^spy[a-zA-Z]+/', $expectedName)) {
            return lcfirst(ltrim($expectedName, 'spy')) . 'Entity';
        }

        return $expectedName;
    }

    /**
     * @param \PhpParser\Node\Param $param
     * @param string $expectedName
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     *
     * @return bool
     */
    protected function shouldSkipParam(Param $param, string $expectedName, ClassMethod $classMethod): bool
    {
        /** @var string $paramName */
        $paramName = $this->getName($param);

        if ($this->breakingVariableRenameGuard->shouldSkipParam($paramName, $expectedName, $classMethod, $param)) {
            return \true;
        }

        // promoted property
        if (!$this->isName($classMethod, MethodName::CONSTRUCT)) {
            return \false;
        }

        return $param->flags !== 0;
    }
}
