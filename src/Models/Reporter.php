<?php

namespace wolfram\Models;


class Reporter
{
    private $path = __DIR__ . '/../../reports';

    private $ectension = '.html';

    private $maskName = 'report_{date}';

    private $template = '/../Templates/Report.tpl';

    private $title;

    private $data;




    public function run()
    {

    }

    public function getTemplate()
    {
        $tpl = file_get_contents($this->template);
        var_dump($tpl)
    }
}