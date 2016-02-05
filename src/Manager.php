<?php

namespace wolfram;

class Manager
{
    private $options = [
        'url' => null,
        'depth' => 3
    ];

    private $crawler;
    private $data;

    /**
     * Manager constructor.
     * @param Crawler $crawler
     */
    public function __construct(Crawler $crawler)
    {
        $options = getopt(false, ['url::', 'depth:']);

        $this->options = array_merge($this->options, $options);
        $this->crawler = $crawler;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        $this->crawler->setUrl($this->options['url'])
            ->setDepth($this->options['depth'])
            ->setSearchTag('img')
            ->run();

        $this->data = $this->crawler->getData();
    }

}