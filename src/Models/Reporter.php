<?php

namespace wolfram\Models;


use wolfram\Interfaces\ReporterInterface;

class Reporter implements ReporterInterface
{
    private $path = '/../../reports/';

    private $extension = '.html';

    private $maskName = 'report_{date}';

    private $template = '/../Templates/Report.tpl';

    private $title;

    private $data;


    /**
     * Set path for reports
     *
     * @param string $path
     */
    public function setPath($path)
    {
        $this->path = $path;
    }

    /**
     * set Extension for file
     *
     * @param string $extension
     */
    public function setExtension($extension)
    {
        $this->extension = $extension;
    }

    /**
     * Set Mask for name file
     *
     * @param string $maskName
     */
    public function setMaskName($maskName)
    {
        $this->maskName = $maskName;
    }

    /**
     * Set path to template file
     *
     * @param string $template
     */
    public function setTemplate($template)
    {
        $this->template = $template;
    }


    /**
     * Set Data for report
     *
     * @param mixed $data
     *
     * @return Reporter
     */
    public function setData($data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * Set report's title
     *
     * @param mixed $title
     *
     * @return $this
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return $this;
    }


    /**
     *
     * Start writing report
     *
     */
    public function run()
    {
        $content = $this->createContent();
        $tpl = $this->getTemplateRaw();
        $report = str_replace(['{title}', '{content}']
            , [$this->title, $content]
            , $tpl);

        $file = $this->createFileName();
        file_put_contents($file, $report);
    }

    /**
     * This method get raw data from template file
     *
     * @return string
     */
    private function getTemplateRaw()
    {
        $tpl = file_get_contents(__DIR__ . $this->template);
        return $tpl;
    }

    /**
     * This method generate table from data
     *
     * @return string
     */
    private function createContent()
    {
        $headTable = '<tr><th>Url</th><th>Time analyze</th><th>Number of images</th></tr>';
        $body = '';
        foreach ($this->data as $record) {
            $body .= "<tr><td><a href='{$record['url']}'>{$record['url']}</a></td>
                        <td>{$record['time']}</td>
                        <td>{$record['countImg']}</td></tr>";
        }
        return '<table>' . $headTable . $body . '</table>';
    }

    /**
     * This method generate name for file
     *
     * @return string
     */
    private function createFileName()
    {
        $filename = str_replace('{date}'
                , date('d.m.Y')
                , $this->maskName) . $this->extension;
        return __DIR__ . $this->path . $filename;
    }


}