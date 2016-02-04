<?php

namespace wolfram;

class Crawler
{
    private $options = [
        'url' => null,
        'depth' => 3
    ];

    public function __construct()
    {
        $options = getopt(false, ['url::', 'depth:']);
        $this->options = array_merge($this->options, $options);
    }
}