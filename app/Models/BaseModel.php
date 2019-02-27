<?php

namespace kirpykla_dev\Models;

use mysql_xdevapi\Exception;
use PDO;
//shows some data on the homepage
class BaseModel
{
    public $kirpejai_table = "tb_kirpejai";
    public $klientai_table = "tb_klientai";
    public $rezervacijos_table = "tb_rezervacijos";

    protected $connection;

    function __construct()
    {

    }

    public function connect() {

        //leiskime tik 1 prisijungima
        if(empty($this->connection)) {
            $conn = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_DATABASE);
            if (mysqli_connect_error()) {
//            throw new Exception('DB connect error');
            }
            mysqli_query($conn, 'SET NAMES utf8');
            mysqli_query($conn, 'SET CHARACTER SET utf8');
            mysqli_set_charset($conn, 'utf8');
            $this->connection = $conn;
        }

        return $this->connection;
    }

    public function SqlResultsToArray($sql)
    {
        $return = array();
        if (!$sql) {
            return false;
        }

        while ($rw = mysqli_fetch_array($sql, MYSQLI_ASSOC)) {
            $return[] = $rw;
        }

        return $return;

    }

    public function sql($conn, $query) {
        $result = mysqli_query($conn, $query);
        return $result;
    }

    public function check_db($conn,$text) {
        //DB escaping toolsas
        $text = str_replace(['%', '´'], ['', ''], $text);
        if (!get_magic_quotes_gpc()) {
            $text = addslashes($text);
        }
        $text=mysqli_real_escape_string($conn,$text);
        return $text;
    }
}