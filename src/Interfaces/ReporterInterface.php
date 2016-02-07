<?php

namespace wolfram\Interfaces;

interface ReporterInterface
{
    /**
     * Set path for reports
     *
     * @param string $path
     */
    public function setPath($path);


    /**
     * set Extension for file
     *
     * @param string $extension
     */
    public function setExtension($extension);


    /**
     * Set Mask for name file
     *
     * @param string $maskName
     */
    public function setMaskName($maskName);

    /**
     * Set path to template file
     *
     * @param string $template
     */
    public function setTemplate($template);


    /**
     * Set Data for report
     *
     * @param mixed $data
     */
    public function setData($data);


    /**
     * Set report's title
     *
     * @param mixed $title
     */
    public function setTitle($title);

    /**
     *
     * Start writing report
     *
     */
    public function run();


}