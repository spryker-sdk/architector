<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

declare(strict_types=1);

namespace SprykerSdk\Architector\Rename\ClassMethod;

use ArrayObject;
use Exception;
use PhpParser\Node;
use PhpParser\Node\Expr\Assign;
use PhpParser\Node\Expr\New_;
use PhpParser\Node\Expr\Variable;
use PhpParser\Node\Stmt\ClassMethod;
use Propel\Runtime\Collection\ObjectCollection;
use Rector\Core\Contract\Rector\AllowEmptyConfigurableRectorInterface;
use Rector\Core\Rector\AbstractRector;
use Rector\Naming\Guard\BreakingVariableRenameGuard;
use Rector\Naming\Naming\ExpectedNameResolver;
use Rector\Naming\VariableRenamer;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\ConfiguredCodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use Throwable;

final class RenameVariableToMatchNewTypeRector extends AbstractRector implements AllowEmptyConfigurableRectorInterface
{
    /**
     * @var \Rector\Naming\Guard\BreakingVariableRenameGuard
     */
    private BreakingVariableRenameGuard $breakingVariableRenameGuard;

    /**
     * @var \Rector\Naming\Naming\ExpectedNameResolver
     */
    private ExpectedNameResolver $expectedNameResolver;

    /**
     * @var \Rector\Naming\VariableRenamer
     */
    private VariableRenamer $variableRenamer;

    /**
     * @var string
     */
    public const CLASSES_TO_SKIP = 'classes_to_skip';

    /**
     * @var array<string, array<string, mixed>>
     */
    private array $configuration = [
        'classes_to_skip' => [],
    ];

    /**
     * @var array<string>
     */
    private $classesToSkip = [
        ObjectCollection::class,
        FormBuilderInterface::class,
        FormBuilderInterface::class,
        OptionsResolver::class,
        FormView::class,
        Throwable::class,
        ArrayObject::class,
        Exception::class,
    ];

    /**
     * @param \Rector\Naming\Guard\BreakingVariableRenameGuard $breakingVariableRenameGuard
     * @param \Rector\Naming\Naming\ExpectedNameResolver $expectedNameResolver
     * @param \Rector\Naming\VariableRenamer $variableRenamer
     */
    public function __construct(
        BreakingVariableRenameGuard $breakingVariableRenameGuard,
        ExpectedNameResolver $expectedNameResolver,
        VariableRenamer $variableRenamer
    ) {
        $this->breakingVariableRenameGuard = $breakingVariableRenameGuard;
        $this->expectedNameResolver = $expectedNameResolver;
        $this->variableRenamer = $variableRenamer;
    }

    /**
     * @param array $configuration
     *
     * @return void
     */
    public function configure(array $configuration): void
    {
        $classesToSkip = $configuration[static::CLASSES_TO_SKIP] ?? $configuration;

        $this->classesToSkip = array_merge($classesToSkip, $this->classesToSkip);
    }

    /**
     * @return \Symplify\RuleDocGenerator\ValueObject\RuleDefinition
     */
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Rename variable to match new ClassType', [new ConfiguredCodeSample(<<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $search = new DreamSearch();
        $search->advance();
    }
}
CODE_SAMPLE, <<<'CODE_SAMPLE'
final class SomeClass
{
    public function run()
    {
        $dreamSearch = new DreamSearch();
        $dreamSearch->advance();
    }
}
CODE_SAMPLE, $this->configuration)]);
    }

    /**
     * @return array<class-string<\PhpParser\Node>>
     */
    public function getNodeTypes(): array
    {
        return [ClassMethod::class];
    }

    /**
     * @param \PhpParser\Node\Stmt\ClassMethod $node
     *
     * @return \PhpParser\Node|null
     */
    public function refactor(Node $node): ?Node
    {
        $hasChanged = \false;
        $assignsOfNew = $this->getAssignsOfNew($node);
        foreach ($assignsOfNew as $assignOfNew) {
            $newExpr = $assignOfNew->expr;
            if ($newExpr instanceof New_) {
                $className = (string)$newExpr->class;
                if (in_array($className, $this->classesToSkip)) {
                    continue;
                }
            }

            $expectedName = $this->expectedNameResolver->resolveForAssignNew($assignOfNew);
            /** @var \PhpParser\Node\Expr\Variable $variable */
            $variable = $assignOfNew->var;
            if ($expectedName === null) {
                continue;
            }
            if ($this->isName($variable, $expectedName)) {
                continue;
            }
            $currentName = $this->getName($variable);
            if ($currentName === null) {
                continue;
            }
            if ($this->breakingVariableRenameGuard->shouldSkipVariable($currentName, $expectedName, $node, $variable)) {
                continue;
            }

            $expectedName = $this->getExpectedName($expectedName);

            $hasChanged = \true;
            // 1. rename assigned variable
            $assignOfNew->var = new Variable($expectedName);
            // 2. rename variable in the
            $this->variableRenamer->renameVariableInFunctionLike($node, $currentName, $expectedName, $assignOfNew);
        }
        if (!$hasChanged) {
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
     * @param \PhpParser\Node\Stmt\ClassMethod $classMethod
     *
     * @return array<\PhpParser\Node\Expr\Assign>
     */
    private function getAssignsOfNew(ClassMethod $classMethod): array
    {
        /** @var array<\PhpParser\Node\Expr\Assign> $assigns */
        $assigns = $this->betterNodeFinder->findInstanceOf((array)$classMethod->stmts, Assign::class);

        return array_filter($assigns, function (Assign $assign): bool {
            return $assign->expr instanceof New_;
        });
    }
}
