<?php

namespace kirpykla_dev\Controllers;

use League\Plates\Engine;

class IndexController extends BaseController
{
    public function __construct()
    {
        $this->getHomePage();
    }

    private function getHomePage()
    {
        $templates = new Engine(BASE.DS.'Views');
        echo $templates->render('index_page', ['title' => 'Kirpykla index page']);
        echo $rez;
    }
}
