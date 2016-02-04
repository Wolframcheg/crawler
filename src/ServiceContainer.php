<?php

namespace wolfram;

class ServiceContainer extends \ArrayObject
{
    public function get($key)
    {
        if (is_callable($this[$key])) {
            return call_user_func($this[$key]);
        }

        throw new \RuntimeException("Can not find service definition under the key [ $key ]");
    }
}