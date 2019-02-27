<?php

namespace kirpykla_dev\Models;

class RezervacijosModel extends BaseModel
{
    private $conn;

    const DAY_BEGIN = '10:00:00';
    const DAY_END = '20:00:00';

    private $sort_cols_mapper = array(
        'time' => ['rezervacijos_data ASC', 'rezervacijos_laikas ASC'],
        'stat' => 'kliento_stat DESC',
        'kirpejas' => 'kirpejo_vardas ASC',
        'klientas' => 'kliento_vardas ASC'
    );

    function __construct()
    {
        $this->conn = $this->connect();
    }

    public function GetReservations($date, $name, $sort) {
        $date = $this->check_db($this->conn, $date);
        $name = $this->check_db($this->conn, $name);
        $where  = !empty($date) ? "AND rezervacijos_data = '$date' " : '';
        $where  .= !empty($name) ? "AND kliento_vardas LIKE '%$name%' " : '';

        if(!empty($sort) && array_key_exists($sort, $this->sort_cols_mapper)) {
            $sort_column = $this->sort_cols_mapper[$sort];
            if(is_array($sort_column)) {
                $sort = " ORDER BY ".implode(',', $sort_column);
            }
            else {
                $sort = " ORDER BY $sort_column";
            }
        }

        $query = "SELECT $this->rezervacijos_table.*, kirpejo_vardas, kliento_vardas, kliento_stat 
                  FROM $this->rezervacijos_table
                  INNER JOIN $this->kirpejai_table ON rezervacijos_kirpejo_id=kirpejo_id 
                  INNER JOIN $this->klientai_table ON rezervacijos_kliento_id=kliento_id 
                  WHERE 
                    rezervacijos_aktyvus='1' $where
                   $sort";
        $sql = $this->sql($this->conn, $query);
        $results = $this->SqlResultsToArray($sql);

        return $results;
    }

    public function GetReservationById($resevation_id) {
        $resevation_id = $this->check_db($this->conn, $resevation_id);

        $query = "SELECT $this->rezervacijos_table.*, kirpejo_vardas, kliento_vardas, kliento_stat 
                  FROM $this->rezervacijos_table
                  INNER JOIN $this->kirpejai_table ON rezervacijos_kirpejo_id=kirpejo_id 
                  INNER JOIN $this->klientai_table ON rezervacijos_kliento_id=kliento_id 
                  WHERE 
                    rezervacijos_aktyvus='1' AND rezervacijos_id='$resevation_id'
                   ";
        $sql = $this->sql($this->conn, $query);
        $results = $this->SqlResultsToArray($sql);

        return $results[0];
    }

    public function GetWorkingTimes($only_future = false) {
        $booking_times = array();

        $begin_time = strtotime(self::DAY_BEGIN);
        $end_time = strtotime(self::DAY_END);
        $current_time = time();
        while($begin_time <= $end_time) {
            $book_time = date("H:i", $begin_time);
            if(!$only_future || ($only_future && $begin_time>=$current_time)) {
                $booking_times[$book_time] = $book_time;
            }
            $begin_time = strtotime("$book_time +15 min");
        }
        return $booking_times;
    }

    public function CheckRegistrationAvailable($kirpejo_id, $data, $laikas) {
        $kirpejo_id = $this->check_db($this->conn, $kirpejo_id);
        $data = $this->check_db($this->conn, $data);
        $laikas = $this->check_db($this->conn, $laikas);

        $query = "SELECT rezervacijos_id FROM $this->rezervacijos_table 
            WHERE rezervacijos_data='$data' AND 
                rezervacijos_laikas='$laikas:00' AND 
                rezervacijos_kirpejo_id='$kirpejo_id' AND 
                rezervacijos_aktyvus='1'";
        $sql = $this->sql($this->conn, $query);
        return mysqli_num_rows($sql)==0;
    }

    public function CheckClientHaveNoFutureRegistrations($kliento_id) {
        $query = "SELECT rezervacijos_id FROM $this->rezervacijos_table 
            WHERE 
                (
                    rezervacijos_data > NOW() 
                    OR 
                    (rezervacijos_data = NOW() AND rezervacijos_laikas > NOW())
                 ) AND  
                rezervacijos_kliento_id='$kliento_id' AND 
                rezervacijos_aktyvus='1'";
        $sql = $this->sql($this->conn, $query);
        return mysqli_num_rows($sql)==0;
    }

    public function RegistrationSave($kirpejo_id, $kliento_id, $data, $laikas) {
        $kirpejo_id = $this->check_db($this->conn, $kirpejo_id);
        $kliento_id = $this->check_db($this->conn, $kliento_id);
        $data = $this->check_db($this->conn, $data);
        $laikas = $this->check_db($this->conn, $laikas);

        $query = "INSERT INTO $this->rezervacijos_table (
            rezervacijos_data, 
            rezervacijos_laikas, 
            rezervacijos_kirpejo_id, 
            rezervacijos_kliento_id,
            rezervacijos_aktyvus)
            VALUES ('$data', '$laikas', '$kirpejo_id', '$kliento_id', '1')";
        $this->sql($this->conn, $query);

        return mysqli_insert_id($this->conn);
    }

    public function RegistrationCancel($reservation_id) {
        $reservation_id = $this->check_db($this->conn, $reservation_id);
        $query = "UPDATE $this->rezervacijos_table SET rezervacijos_aktyvus='0' WHERE rezervacijos_id='$reservation_id'";
        $this->sql($this->conn, $query);
    }
}