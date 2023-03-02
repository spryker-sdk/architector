<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Orm\Zed\FooBar\Persistence\SpyFooBar;

class FooBar
{
    /**
     * @return \Orm\Zed\FooBar\Persistence\SpyFooBar
     */
    public function fooBarMethod()
    {
        $foo = new SpyFooBar();

        return $foo;
    }
}
-----
<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Orm\Zed\FooBar\Persistence\SpyFooBar;

class FooBar
{
    /**
     * @return \Orm\Zed\FooBar\Persistence\SpyFooBar
     */
    public function fooBarMethod()
    {
        $fooBarEntity = new SpyFooBar();

        return $fooBarEntity;
    }
}
