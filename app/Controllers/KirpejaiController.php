<?php

namespace kirpykla_dev\Controllers;

//use kirpykle_dev\Models\KirpejaiModel;
use function Couchbase\passthruEncoder;
use kirpykla_dev\Models\KirpejaiModel;
use kirpykla_dev\Models\KlientaiModel;
use kirpykla_dev\Models\RezervacijosModel;
use League\Plates\Engine;

class KirpejaiController extends BaseController
{
    private $template;
    private $model;

    CONST PAGING_SIZE = 2;

    public function __construct($fun_name = null, $params = null, $post = null)
    {
        $this->template = new Engine(BASE.DS.'Views');
//        $this->model = new

        if(method_exists ($this, $fun_name)) {
            if(empty($post)) {
                $this->$fun_name($params);
            }
            else {
                $this->$fun_name($params, $post);
            }
        }
        else {
            echo "nera tokio metodo";
        }
    }

    private function kirpejai_list($params, $post = null)
    {
        $kirpejai_model = new KirpejaiModel();
        $rezervacijos_model = new RezervacijosModel();

//        $kirpeju_sarasas = $kirpejai_model->GetKirpejaiList();
//        $imanomi_laikai = $rezervacijos_model->GetWorkingTimes(false);
//        print_r($params);
//        print_r($post);
        $date = isset($params['data']) ? $params['data'] : date("Y-m-d");
        $name = isset($params['klientas']) ? $params['klientas'] : '';
        $sort = isset($params['sort']) ? $params['sort'] : 'stat';
        $page_number = isset($params['page_num']) && is_numeric($params['page_num']) ? $params['page_num'] : 1;


        $dienos_rezervacijos = $rezervacijos_model->GetReservations($date, $name, $sort);

        list($prev_page, $next_page, $dienos_rezervacijos) = $this->ProcessListPaging($dienos_rezervacijos, $page_number);

        $user_stats = $this->GetUserStatsForReservationList($dienos_rezervacijos);
//        print_r($dienos_rezervacijos);
//        print_r($user_stats);

//        print_r($kirpeju_sarasas);
//        print_r($imanomi_laikai);
//        print_r($dienos_rezervacijos);
        $qs = http_build_query($params);
        echo $this->template->render('reservation_list', [
            'title' => 'Kirpejo pasirinkimas',
            'kirpejai' => $dienos_rezervacijos,
            'data' => $date,
            'klientas' => $name,
            'url' => $qs,
            'prev_page' => $prev_page,
            'next_page' => $next_page,
            'stat' => $user_stats
        ]);
    }

    private function new_kirpejo_rezervacija($params) {
        $kirpejai_model = new KirpejaiModel();
        $rezervacijos_model = new RezervacijosModel();

        $kirpeju_sarasas = $kirpejai_model->GetKirpejaiList();
        $imanomi_laikai = $rezervacijos_model->GetWorkingTimes(false);
        $date = isset($params['date']) ? $params['date'] : date("Y-m-d");
        echo $this->template->render('new_reservation', ['title' => 'Nauja rezervacija', 'data'=>$date, 'laikai' => $imanomi_laikai, 'time'=>'', 'kirpejai' => $kirpeju_sarasas]);
    }

    private function ProcessListPaging($sarasas, $current_page) {
        $pages_total = ceil(count($sarasas) / self::PAGING_SIZE);

        $sarasas_return = array();

        for($i=($current_page-1)*self::PAGING_SIZE; $i<$current_page*self::PAGING_SIZE;$i++) {
            if(array_key_exists($i, $sarasas)) {
                $sarasas_return[] = $sarasas[$i];
            }
        }
        $prev_page = $current_page > 1 ? $current_page-1 : false;
        $next_page = $current_page < $pages_total ? $current_page+1 : false;
        return array($prev_page, $next_page, $sarasas_return);
    }

    private function GetUserStatsForReservationList($dienos_rezervacijos) {
        $klientu_idai = array();
        foreach ($dienos_rezervacijos as $d) {
            $klientu_idai[] = $d['rezervacijos_kliento_id'];
        }
        $klientu_idai = array_unique($klientu_idai);

        $klientu_model = new KlientaiModel();
        $klientu_stats = $klientu_model->GetKlientaiStat($klientu_idai);

        return $klientu_stats;
    }
}
