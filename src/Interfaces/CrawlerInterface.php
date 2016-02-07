<?php

namespace wolfram\Interfaces;

interface CrawlerInterface
{
    /**
     * Set url
     *
     * @param $url
     */
    public function setUrl($url);

    /**
     * Set depth
     *
     * @param $depth
     */
    public function setDepth($depth);

    /**
     * Set searchTag
     *
     * @param $searchTag
     */
    public function setSearchTag($searchTag);

    /**
     * Start Process
     *
     * @return mixed
     */
    public function run();

    /**
     * Get Data
     *
     * @return array
     */
    public function getData();


}