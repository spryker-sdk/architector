<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Pyz\Zed\FooBar\Persistence\FooBarQueryContainerInterface;

class FooBar
{
    /**
     * @param \Pyz\Zed\FooBar\Persistence\FooBarQueryContainerInterface $fooBarQueryContainer
     *
     * @return void
     */
    public function fooBarMethod(FooBarQueryContainerInterface $fooBarQueryContainer)
    {
        $foo = $fooBarQueryContainer;
    }
}
-----
<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use ArrayObject;

class FooBar
{
    /**
     * @param FooBarQueryContainerInterface $queryContainer
     *
     * @return void
     */
    public function fooBarMethod(FooBarQueryContainerInterface $queryContainer)
    {
        $foo = $queryContainer;
    }
}
