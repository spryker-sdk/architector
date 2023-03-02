<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Orm\Zed\FooBar\Persistence\SpyFooBarQuery;

class FooBar
{
    /**
     * @return \Orm\Zed\FooBar\Persistence\SpyFooBarQuery
     */
    public function fooBarMethod()
    {
        $foo = new SpyFooBarQuery();

        return $foo;
    }
}
-----
<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Orm\Zed\FooBar\Persistence\SpyFooBarQuery;

class FooBar
{
    /**
     * @return \Orm\Zed\FooBar\Persistence\SpyFooBarQuery
     */
    public function fooBarMethod()
    {
        $fooBarQuery = new SpyFooBarQuery();

        return $fooBarQuery;
    }
}
