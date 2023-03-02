<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use ArrayObject;

class FooBar
{
    /**
     * @return ArrayObject
     */
    public function fooBarMethod()
    {
        $foo = new ArrayObject();

        return $foo;
    }
}
-----
<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use ArrayObject;

class FooBar
{
    /**
     * @return ArrayObject
     */
    public function fooBarMethod()
    {
        $foo = new ArrayObject();

        return $foo;
    }
}
