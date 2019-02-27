<?php

namespace kirpykla_dev\Models;

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
        $list = array();
        foreach ($results as $r) {
            $list[$r['kirpejo_id']] = $r['kirpejo_vardas'];
        }
        return $list;
    }
}