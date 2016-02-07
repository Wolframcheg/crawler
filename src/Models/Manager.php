<?php

namespace wolfram\Models;

use wolfram\Interfaces\CrawlerInterface;
use wolfram\Interfaces\ReporterInterface;

class Manager
{
    private $options = [
        'url' => null,
        'depth' => 3
    ];

    private $crawler;
    private $reporter;
    private $data;

    /**
     * Manager constructor.
     * @param CrawlerInterface $crawler
     * @param ReporterInterface $reporter
     */
    public function __construct(CrawlerInterface $crawler, ReporterInterface $reporter)
    {
        $options = getopt(false, ['url::', 'depth:']);

        $this->options = array_merge($this->options, $options);
        $this->crawler = $crawler;
        $this->reporter = $reporter;
    }

    /**
     * Get Data from Crawler
     *
     * @return Manager
     */
    public function getData()
    {
        $this->crawler->setUrl($this->options['url'])
            ->setDepth($this->options['depth'])
            ->setSearchTag('img')
            ->run();

        $this->data = $this->crawler->getData();
        return $this;
    }

    /**
     * Sorting Data
     *
     * @param string $sortBy
     * @return Manager
     */
    public function sortData($sortBy = 'countImg')
    {
        usort($this->data, function ($a, $b) use ($sortBy) {
            return ($b[$sortBy] - $a[$sortBy]);
        });
        return $this;
    }

    /**
     *  Generate Report and write it to file
     *
     * @return Manager
     */
    public function reportData()
    {
        $this->reporter->setTitle($this->options['url'])
            ->setData($this->data)
            ->run();
        return $this;
    }

}