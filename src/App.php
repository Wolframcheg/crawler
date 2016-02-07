<?php

namespace wolfram;

use \Exception;
use wolfram\Models\ServiceContainer;

class App
{
    private $container;

    /**
     * App constructor.
     * @param ServiceContainer $container
     */
    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    /**
     * Start application
     */
    public function run()
    {
        $this->container->get('manager')
            ->getData()
            ->sortData()
            ->reportData();
    }

}