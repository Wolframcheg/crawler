<?php

namespace wolfram\Models;

use \DOMDocument;
use wolfram\Interfaces\CrawlerInterface;

class Crawler implements CrawlerInterface
{
    /**
     * @var string Start URI
     */
    private $url;

    /**
     * @var integer Search Depth
     */
    private $depth;

    /**
     * @var string Domain
     */
    private $host;

    /**
     * @var array Processed page
     */
    private $seen = [];

    /**
     * @var array Data about processed pages
     */
    private $data = [];

    /**
     * @var string The name of tag
     */
    private $searchTag;

    /**
     * Set url
     *
     * @param $url
     *
     * @return Crawler
     */
    public function setUrl($url)
    {
        $this->url = $url;
        $parse = parse_url($url);
        $this->host = $parse['host'];
        return $this;
    }

    /**
     * Set depth
     *
     * @param $depth
     *
     * @return Crawler
     */
    public function setDepth($depth)
    {
        $this->depth = $depth;
        return $this;
    }

    /**
     * Set searchTag
     *
     * @param $searchTag
     *
     * @return Crawler
     */
    public function setSearchTag($searchTag)
    {
        $this->searchTag = $searchTag;
        return $this;
    }

    /**
     * Get Data
     *
     * @return array
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * Start Process
     *
     * @return mixed
     */
    public function run()
    {
        $this->crawlPage($this->url, $this->depth);
    }

    /**
     * This method found child links in page and send they to crawlPage()
     *
     * @param \DOMDocument $dom A \DOMDocument instance
     * @param string $url The URI of the current page
     * @param integer $depth The Depth for current page
     */
    private function processLinks(DOMDocument $dom, $url, $depth)
    {
        $anchors = $dom->getElementsByTagName('a');
        foreach ($anchors as $element) {
            $href = $element->getAttribute('href');
            if (0 !== strpos($href, 'http')) {
                $path = '/' . ltrim($href, '/');
                if (extension_loaded('http')) {
                    $href = http_build_url($url, ['path' => $path]);
                } else {
                    $parts = parse_url($url);
                    $href = $parts['scheme'] . '://';
                    $href .= $parts['host'];
                    if (isset($parts['port'])) {
                        $href .= ':' . $parts['port'];
                    }
                    $href .= $path;
                }
            }
            $this->crawlPage($href, $depth - 1);
        }
    }

    /**
     * Function for get content by URI
     *
     * @param string $url The URI of page
     * @return array
     */
    private function getContent($url)
    {
        $handle = curl_init($url);

        curl_setopt($handle, CURLOPT_RETURNTRANSFER, TRUE);

        /* Get the HTML or whatever is linked in $url. */
        $response = curl_exec($handle);
        // response total time
        $time = curl_getinfo($handle, CURLINFO_TOTAL_TIME);
        /* Check for 404 (file not found). */
        $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
        curl_close($handle);
        return [$response, $httpCode, $time];
    }

    /**
     * This method validate URI
     *
     * @param string $url URI for checking
     * @param integer $depth Depth
     * @return bool
     */
    private function isValid($url, $depth)
    {
        $url = preg_replace('/^[\s\S]+(?=\#)/', '', $url);
        $url = rtrim($url, '/');

        if (strpos($url, $this->host) === false
            || $depth === 0
            || isset($this->seen[$url])
            || isset($this->seen[$url])
        ) return false;

        return true;
    }

    /**
     * This method crawling page and set data about it in $data property
     *
     * @param string $url URI for crawling
     * @param integer $depth Depth
     */
    private function crawlPage($url, $depth)
    {
        if (!$this->isValid($url, $depth)) return;

        $this->seen[$url] = true;

        list($content, $httpCode, $time) = $this->getContent($url);
        if ($httpCode != 200) return;

        $dom = new DOMDocument('1.0');
        @$dom->loadHTML($content);

        $countImg = $dom->getElementsByTagName($this->searchTag)->length;
        //save data
        array_push($this->data, [
            'url' => $url,
            'time' => $time,
            'countImg' => $countImg,
            'httpCode' => $httpCode
        ]);

        $this->processLinks($dom, $url, $depth);
    }

}