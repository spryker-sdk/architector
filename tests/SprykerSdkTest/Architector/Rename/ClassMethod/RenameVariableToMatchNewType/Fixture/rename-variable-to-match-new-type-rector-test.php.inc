<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Generater\Shared\Transfer\FooBarTransfer;

class FooBar
{
    /**
     * @return \Generater\Shared\Transfer\FooBarTransfer
     */
    public function fooBarMethod()
    {
        $foo = new FooBarTransfer();

        return $foo;
    }
}
-----
<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Generater\Shared\Transfer\FooBarTransfer;

class FooBar
{
    /**
     * @return \Generater\Shared\Transfer\FooBarTransfer
     */
    public function fooBarMethod()
    {
        $fooBarTransfer = new FooBarTransfer();

        return $fooBarTransfer;
    }
}
