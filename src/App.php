<?php

namespace wolfram;

use \Exception;

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
     *
     * @return bool
     */
    public function run()
    {
        try {
            $manager = $this->container->get('manager');
            $manager->getData();

            return true;
        } catch (Exception $e) {
            $this->_errorMessage = 'ERROR: ' . $e->getMessage();
        }
        return false;
    }

}