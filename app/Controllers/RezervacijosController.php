<?php

namespace kirpykla_dev\Controllers;

//use kirpykle_dev\Models\KirpejaiModel;
use function Couchbase\passthruEncoder;
use kirpykla_dev\Models\KirpejaiModel;
use kirpykla_dev\Models\KlientaiModel;
use kirpykla_dev\Models\RezervacijosModel;
use League\Plates\Engine;
use League\Plates\Template\Data;

class RezervacijosController extends BaseController
{
    private $template;
    private $model;

    public function __construct($fun_name = null, $params = null)
    {
        $this->template = new Engine(BASE.DS.'Views');

        if(method_exists ($this, $fun_name)) {
            $this->$fun_name($params);
        }
        else {
            echo "nera tokio metodo";
        }
    }

    private function check_registration_valid($params) {
        $rezervacijos_model = new RezervacijosModel();
        $kliento_model = new KlientaiModel();

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
            $booking_available = $rezervacijos_model->CheckRegistrationAvailable($kirpejo_id, $data, $laikas);
            if(!$booking_available) {
                $msg = 'Norimas laikas pas šią kirpėją užimtas';
            }
            else {
                //patikrinkime, ar klientas neturi jau aktyviu registraciju
                $kliento_id = $kliento_model->GetClientId($klientas);
                if($kliento_id) {
                    //kai jau turime ID atlikime paieska ateityje. Jeigu ID nera - vardas naujas
                    $booking_available = $rezervacijos_model->CheckClientHaveNoFutureRegistrations($kliento_id);
                    if(!$booking_available) {
                        $msg = 'Rezervavimas negalimas. Jau yra aktyvių rezervacijų';
                    }
                }
            }
        }
        echo $this->template->render('json_answer', ['json' => ['response' => (bool)$booking_available, 'msg' => $msg]]);
    }

    private function new_kirpejo_rezervacija_save($params) {
        $reservation_id = $this->save_reservation($params);

        if(isset($params['next_page'])) {
            header('Location: ?page='.urldecode($params['next_page']));
        }
        else {
            header('Location: ?page=kliento_puslapis');
        }
    }

    private function save_reservation($params) {
        $rezervacijos_model = new RezervacijosModel();
        $klientai_model = new KlientaiModel();

        $kirpejo_id = $params['kirpejas'];
        $data = $params['data'];
        $laikas = $params['time'];
        $klientas = $params['klientas'];

        $registracijos_id = false;
        if(empty($kirpejo_id) || empty($data) || empty($laikas) || empty($klientas)) {
            $error = true;
        }
        elseif (strtotime("$data $laikas") < time()) {
            $error = true;
        }
        else {
            $booking_available = $rezervacijos_model->CheckRegistrationAvailable($kirpejo_id, $data, $laikas);
            if($booking_available) {
                $kliento_id = $klientai_model->GetRegisterClient($klientas);
                $registracijos_id = $rezervacijos_model->RegistrationSave($kirpejo_id, $kliento_id, $data, $laikas);
                $klientai_model->UpdateKlientaiStat($kliento_id);
            }
            else {
                $error = true;
            }
        }
        return $registracijos_id;
    }

    private function cancel_kirpejo_rezervacija($params) {
        $rezervacijos_model = new RezervacijosModel();
        $rezervacijos_id = isset($params['id']) ? $params['id'] : false;
        if(is_numeric($rezervacijos_id) && $rezervacijos_id>0) {
            $rezervacijos_model->RegistrationCancel($rezervacijos_id);
        }
        header('Location: ?page='.urldecode($params['next_page']));
    }

    private function kliento_puslapis($params) {
        $kirpejai_model = new KirpejaiModel();
        $kirpejai_list = $kirpejai_model->GetKirpejaiList();

        $date = isset($params['data']) ? $params['data'] : date("Y-m-d");
        $params['data'] = $date;

        $rezervation_model = new RezervacijosModel();
        $galimi_lakiai = $rezervation_model->GetWorkingTimes(date("Y-m-d")==$date);
        $dienos_rezervacijos = $rezervation_model->GetReservations($date, '', 'time');

        $dienos_matrica = array_fill_keys($galimi_lakiai, array());

        foreach ($dienos_rezervacijos as $rez) {
            $time = substr($rez['rezervacijos_laikas'],0,-3);
            $kirpejo_id = $rez['rezervacijos_kirpejo_id'];
            if(array_key_exists($time, $galimi_lakiai)) {
                $dienos_matrica[$time][$kirpejo_id] = true;
            }
        }

        //reiskia, kad turime uzsilikusi uzsakyma
        if(isset($_COOKIE['kirpykla_reg_id'])) {
            $book_info = $rezervation_model->GetReservationById($_COOKIE['kirpykla_reg_id']);
            $name = $book_info['kliento_vardas'];
        }
        else {
            $name = '';
            $book_info = null;
        }

        $qs = http_build_query($params);
        echo $this->template->render('kliento_puslapis', [
            'title' => 'Laiko rezervacija',
            'kirpejai' => $kirpejai_list,
            'data' => $date,
            'klientas' => $name,
            'url' => $qs,
            'matrica' => $dienos_matrica,
            'laikai' => $galimi_lakiai,
            'booking' => $book_info
        ]);
    }

    private function save_client_registration($params) {
        $reg_id = $this->save_reservation($params);

        //issaugokime i cookie rezervacijos info
        if($reg_id) {
            $date_booking = strtotime($params['data'].' '.$params['time']);
            $date_now = time();
            $date_diff_in_seconds = $date_booking-$date_now;
            setcookie("kirpykla_reg_id", $reg_id, time() + $date_diff_in_seconds);
        }
        header("Location: ?page=".urldecode($params['next_page']));
    }
}
