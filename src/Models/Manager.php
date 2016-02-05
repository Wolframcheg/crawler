<?php

namespace wolfram\Models;

use wolfram\Interfaces\CrawlerInterface;

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
     * @param CrawlerInterface $crawler
     */
    public function __construct(CrawlerInterface $crawler)
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