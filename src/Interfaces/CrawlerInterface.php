<?php

namespace wolfram\Interfaces;

interface CrawlerInterface
{
    /**
     * Set url
     *
     * @param $url
     *
     * @return CrawlerInterface
     */
    public function setUrl($url);

    /**
     * Set depth
     *
     * @param $depth
     *
     * @return CrawlerInterface
     */
    public function setDepth($depth);

    /**
     * Set searchTag
     *
     * @param $searchTag
     *
     * @return CrawlerInterface
     */
    public function setSearchTag($searchTag);

    /**
     * Start Process
     *
     * @return mixed
     *
     */
    public function run();

    /**
     * Get Data
     *
     * @return array
     */
    public function getData();


}