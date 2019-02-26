<?php

namespace kirpykla_dev\Controllers;

//use kirpykle_dev\Models\KirpejaiModel;
use kirpykla_dev\Models\KirpejaiModel;
use League\Plates\Engine;

class KirpejaiController extends BaseController
{
    private $template;
    private $model;

    public function __construct($fun_name = null, $params = null)
    {
        $this->template = new Engine(BASE.DS.'Views');
//        $this->model = new

        if(method_exists ($this, $fun_name)) {
            $this->$fun_name();
        }
        else {
            echo "nera tokio metodo";
        }
    }

    private function kirpejai_list()
    {
        $kirpejai_model = new KirpejaiModel();
        $kirpeju_sarasas = $kirpejai_model->GetKirpejaiList();
        print_r($kirpeju_sarasas);
        echo $this->template->render('index_page', ['title' => 'List of kirpejai']);
    }
}
