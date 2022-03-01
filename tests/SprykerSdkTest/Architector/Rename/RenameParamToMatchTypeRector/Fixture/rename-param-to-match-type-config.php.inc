<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Pyz\Zed\FooBar\FooBarConfig;
use Pyz\Zed\Gui\Communication\Table\TableConfiguration;

class FooBar
{
    /**
     * @param \Pyz\Zed\FooBar\FooBarConfig $fooBarConfig
     *
     * @return void
     */
    public function __construct(FooBarConfig $fooBarConfig)
    {
        $foo = $fooBarConfig;
    }

    /**
     * @param \Pyz\Zed\Gui\Communication\Table\TableConfiguration $fooBarConfiguration
     *
     * @return void
     */
    protected function configure(TableConfiguration $fooBarConfiguration)
    {
        $foo = $fooBarConfiguration;
    }
}
-----
<?php

namespace Pyz\Zed\FooBar\Business\FooBar;

use Pyz\Zed\FooBar\FooBarConfig;
use Pyz\Zed\Gui\Communication\Table\TableConfiguration;

class FooBar
{
    /**
     * @param \Pyz\Zed\FooBar\FooBarConfig $config
     *
     * @return void
     */
    public function __construct(FooBarConfig $config)
    {
        $foo = $config;
    }

    /**
     * @param \Pyz\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return void
     */
    public function fooBarMethod(TableConfiguration $config)
    {
        $foo = $config;
    }
}
