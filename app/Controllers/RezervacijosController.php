<?php

namespace kirpykla_dev\Controllers;

//use kirpykle_dev\Models\KirpejaiModel;
use function Couchbase\passthruEncoder;
use kirpykla_dev\Models\KirpejaiModel;
use kirpykla_dev\Models\KlientaiModel;
use kirpykla_dev\Models\RezervacijosModel;
use League\Plates\Engine;

class RezervacijosController extends BaseController
{
    private $template;
    private $model;

    public function __construct($fun_name = null, $params = null)
    {
        $this->template = new Engine(BASE.DS.'Views');
//        $this->model = new

        if(method_exists ($this, $fun_name)) {
            $this->$fun_name($params);
        }
        else {
            echo "nera tokio metodo";
        }
    }

    private function check_registration_valid($params) {
        $rezervacijos_model = new RezervacijosModel();

        $kirpejo_id = $params['kirpejas'];
        $data = $params['data'];
        $laikas = $params['time'];
        $klientas = $params['klientas'];

        $msg = '';
        if(empty($kirpejo_id) || empty($data) || empty($laikas) || empty($klientas)) {
            $booking_available = false;
            $msg = 'Užpildyti ne visi laukai';
        }
        elseif (strtotime("$data $laikas") < time()) {
            $booking_available = false;
            $msg = 'Pasirinktas laikas yra praeityje';
        }
        else {
            $booking_available = $rezervacijos_model->ChecRegistrationAvailable($kirpejo_id, $data, $laikas);
            if(!$booking_available) {
                $msg = 'Norimas laikas pas šią kirpėją užimtas';
            }
        }
        echo $this->template->render('json_answer', ['json' => ['response' => (bool)$booking_available, 'msg' => $msg]]);
    }

    private function new_kirpejo_rezervacija_save($params) {
        $rezervacijos_model = new RezervacijosModel();
        $klientai_model = new KlientaiModel();

        $kirpejo_id = $params['kirpejas'];
        $data = $params['data'];
        $laikas = $params['time'];
        $klientas = $params['klientas'];

        $msg = '';
        if(empty($kirpejo_id) || empty($data) || empty($laikas) || empty($klientas)) {
            $error = true;
        }
        elseif (strtotime("$data $laikas") < time()) {
            $error = true;
        }
        else {
            $booking_available = $rezervacijos_model->ChecRegistrationAvailable($kirpejo_id, $data, $laikas);
            if($booking_available) {
                $kliento_id = $klientai_model->GetRegisterClient($klientas);
                $rezervacijos_model->RegistrationSave($kirpejo_id, $kliento_id, $data, $laikas);
                $klientai_model->UpdateKlientaiStat($kliento_id);
            }
            else {
                $error = true;
            }
        }
        header('Location: ?page=kirpejai_list');
    }

    private function cancel_kirpejo_rezervacija($params) {
        $rezervacijos_model = new RezervacijosModel();
        $rezervacijos_id = isset($params['id']) ? $params['id'] : false;
        if(is_numeric($rezervacijos_id) && $rezervacijos_id>0) {
            $rezervacijos_model->RegistrationCancel($rezervacijos_id);
        }
        header('Location: ?page=kirpejai_list');
    }

    private function kliento_puslapis($params) {

    }
}
