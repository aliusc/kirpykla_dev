<?php

namespace kirpykla_dev\Models;

//shows some data on the homepage
use function MongoDB\BSON\toJSON;

class KlientaiModel extends BaseModel
{
    private $conn;

    function __construct()
    {
        $this->conn = $this->connect();
    }

    public function GetKlientaiList() {
        $query = "SELECT * FROM $this->klientai_table ORDER BY kirpejo_vardas";
        $sql = $this->sql($this->conn, $query);
        $results = $this->SqlResultsToArray($sql);

        return $results;
    }

    public function UpdateKlientaiStat($id = false) {
        $stat = $this->GetKlientaiStat($id);
        foreach ($stat as $kl_id => $kl_stat) {
            $query = "UPDATE $this->klientai_table
                        SET kliento_stat=$kl_stat
                        WHERE kliento_id=$kl_id";
            $this->sql($this->conn, $query);
        }
    }

    public function GetKlientaiStat($id = false) {
        if(is_array($id) && !empty($id)) {
            $where = " AND rezervacijos_kliento_id IN (".implode(',', $id).") ";
        }
        else {
            $where = !empty($id) ? " AND rezervacijos_kliento_id = $id " : '';
        }
        $stats = array();

        //stat tik uz senesnes uz NOW registracijas kurios neatsauktos
        $query = "SELECT rezervacijos_kliento_id as id, 
                    COUNT(rezervacijos_id) as stat 
                    FROM $this->rezervacijos_table 
                    WHERE rezervacijos_aktyvus = '1' AND 
                      rezervacijos_data <= NOW() AND 
                      rezervacijos_laikas <= NOW()
                      $where
                    GROUP BY rezervacijos_kliento_id";
        $sql = $this->sql($this->conn, $query);
        $results = $this->SqlResultsToArray($sql);

        foreach ($results as $r) {
            $stats[$r['id']] = $r['stat'];
        }

        return $stats;
    }

    public function GetRegisterClient($klientas_name) {
        $client_id = $this->GetClientId($klientas_name);

        if($client_id) {
            return $client_id;
        }

        return $this->RegisterNewClient($klientas_name);
    }

    public function GetClientId($klientas_name) {
        $klientas_name = $this->check_db($this->conn, $klientas_name);
        $query = "SELECT kliento_id FROM $this->klientai_table WHERE kliento_vardas = '$klientas_name'";
        $sql = $this->sql($this->conn, $query);
        if(mysqli_num_rows($sql)==0) {
            return false;
        }
        $results = $this->SqlResultsToArray($sql);
        return $results[0]['kliento_id'];
    }

    public function RegisterNewClient($klientas_name) {
        $klientas_name = $this->check_db($this->conn, $klientas_name);
        echo $query = "INSERT INTO $this->klientai_table (kliento_vardas, kliento_stat) VALUES ('$klientas_name', 0)";
        $this->sql($this->conn, $query);
        return mysqli_insert_id($this->conn);
    }
}