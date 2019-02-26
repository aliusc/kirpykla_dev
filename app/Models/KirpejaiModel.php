<?php

namespace kirpykla_dev\Models;

//shows some data on the homepage
class KirpejaiModel extends BaseModel
{
    private $conn;

    function __construct()
    {
        $this->conn = $this->connect();
    }

    public function GetKirpejaiList() {
        $query = "SELECT * FROM $this->kirpejai_table ORDER BY kirpejo_vardas";
        $sql = $this->sql($this->conn, $query);
        $results = $this->SqlResultsToArray($sql);

        return $results;
    }
}