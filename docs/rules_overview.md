# 5 Rules Overview

## RemoveInitialTesterCommentRector

Removes the initial comment in tester classes.

- class: [`SprykerSdk\Architector\Codeception\RemoveInitialTesterComment\RemoveInitialTesterCommentRector`](../src/SprykerSdk/Architector/Codeception/RemoveInitialTesterComment/RemoveInitialTesterCommentRector.php)

```diff
 class SomeTest
 {
     use _generated\XPresentationTesterActions;
-
-    /**
-     * Define custom actions here
-     */
 }
```

<br>

## RenameParamToMatchTypeRector

Rename param to match ClassType

:wrench: **configure it!**

- class: [`SprykerSdk\Architector\Rename\ClassMethod\RenameParamToMatchTypeRector`](../src/SprykerSdk/Architector/Rename/ClassMethod/RenameParamToMatchTypeRector.php)

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\ClassMethod\RenameParamToMatchTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameParamToMatchTypeRector::class, [
        RenameParamToMatchTypeRector::CLASSES_TO_SKIP => [
        ],
    ]);
};
```

↓

```diff
 class SomeClass
 {
-    public function run(FooBarTransfer $fooBar)
+    public function run(FooBarTransfer $fooBarTransfer)
     {
-        $foo = $fooBar;
+        $foo = $fooBarTransfer;
     }
 }
```

<br>

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\ClassMethod\RenameParamToMatchTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameParamToMatchTypeRector::class, [
        RenameParamToMatchTypeRector::CLASSES_TO_SKIP => [
        ],
    ]);
};
```

↓

```diff
 class SomeClass
 {
-    public function run(SpyFooBar $fooBar)
+    public function run(SpyFooBar $fooBarEntity)
     {
-        $foo = $fooBar;
+        $foo = $fooBarEntity;
     }
 }
```

<br>

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\ClassMethod\RenameParamToMatchTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameParamToMatchTypeRector::class, [
        RenameParamToMatchTypeRector::CLASSES_TO_SKIP => [
        ],
    ]);
};
```

↓

```diff
 class SomeClass
 {
-    public function run(SpyFooBarQuery $fooBar)
+    public function run(SpyFooBarQuery $fooBarQuery)
     {
-        $foo = $fooBar;
+        $foo = $fooBarQuery;
     }
 }
```

<br>

## RenameParamToMatchTypeRector

Rename param to match ClassType

:wrench: **configure it!**

- class: [`SprykerSdk\Architector\Rename\RenameParamToMatchTypeRector`](../src/SprykerSdk/Architector/Rename/RenameParamToMatchTypeRector.php)

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\RenameParamToMatchTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameParamToMatchTypeRector::class, [
        RenameParamToMatchTypeRector::CLASSES_TO_SKIP => [
        ],
    ]);
};
```

↓

```diff
 class SomeClass
 {
-    public function run(FooBarTransfer $fooBar)
+    public function run(FooBarTransfer $fooBarTransfer)
     {
-        $foo = $fooBar;
+        $foo = $fooBarTransfer;
     }
 }
```

<br>

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\RenameParamToMatchTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameParamToMatchTypeRector::class, [
        RenameParamToMatchTypeRector::CLASSES_TO_SKIP => [
        ],
    ]);
};
```

↓

```diff
 class SomeClass
 {
-    public function run(SpyFooBar $fooBar)
+    public function run(SpyFooBar $fooBarEntity)
     {
-        $foo = $fooBar;
+        $foo = $fooBarEntity;
     }
 }
```

<br>

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\RenameParamToMatchTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameParamToMatchTypeRector::class, [
        RenameParamToMatchTypeRector::CLASSES_TO_SKIP => [
        ],
    ]);
};
```

↓

```diff
 class SomeClass
 {
-    public function run(SpyFooBarQuery $fooBar)
+    public function run(SpyFooBarQuery $fooBarQuery)
     {
-        $foo = $fooBar;
+        $foo = $fooBarQuery;
     }
 }
```

<br>

## RenameVariableToMatchNewTypeRector

Rename variable to match new ClassType

:wrench: **configure it!**

- class: [`SprykerSdk\Architector\Rename\ClassMethod\RenameVariableToMatchNewTypeRector`](../src/SprykerSdk/Architector/Rename/ClassMethod/RenameVariableToMatchNewTypeRector.php)

```php
<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use SprykerSdk\Architector\Rename\ClassMethod\RenameVariableToMatchNewTypeRector;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->ruleWithConfiguration(RenameVariableToMatchNewTypeRector::class, [
        RenameVariableToMatchNewTypeRector::CLASSES_TO_SKIP => [
        ],
    ]);
};
```

↓

```diff
 final class SomeClass
 {
     public function run()
     {
-        $search = new DreamSearch();
-        $search->advance();
+        $dreamSearch = new DreamSearch();
+        $dreamSearch->advance();
     }
 }
```

<br>

## TriggerErrorMessagesWithSprykerPrefixRector

Refactors trigger_error calls to ensure the passed message contains "Spryker: " as prefix.

- class: [`SprykerSdk\Architector\TriggerError\TriggerErrorMessagesWithSprykerPrefixRector`](../src/SprykerSdk/Architector/TriggerError/TriggerErrorMessagesWithSprykerPrefixRector.php)

```diff
-trigger_error('My message', E_USER_DEPRECATED);
+trigger_error('Spryker: My message', E_USER_DEPRECATED);
```

<br>

```diff
-$message = 'Foo';
+$message = 'Spryker: Foo';
 trigger_error($message, E_USER_DEPRECATED);
```

<br>

```diff
-$message = 'Foo' . 'Bar';
+$message = 'Spryker: Foo' . 'Bar';
 trigger_error($message, E_USER_DEPRECATED);
```

<br>

```diff
-$message = 'Foo' . 'Bar' . 'Baz';
+$message = 'Spryker: Foo' . 'Bar' . 'Baz';
 trigger_error($message, E_USER_DEPRECATED);
```

<br>

```diff
-$message = sprintf('Foo %s', $something);
+$message = sprintf('Spryker: Foo %s', $something);
 trigger_error($message, E_USER_DEPRECATED);
```

<br>
