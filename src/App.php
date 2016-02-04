<?php

namespace wolfram;

class App
{
    private $container;

    public function __construct(ServiceContainer $container)
    {
        $this->container = $container;
    }

    public function run()
    {
        try {
            $crawler = $this->container->get('crawler');

            var_dump($crawler);
            return true;
        } catch (Exception $e) {
            $this->_errorMessage = 'ERROR: ' . $e->getMessage();
        }
        return false;
    }

}