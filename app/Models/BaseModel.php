<?php

namespace kirpykla_dev\Models;

use mysql_xdevapi\Exception;
use PDO;
//shows some data on the homepage
class BaseModel
{
    protected $data;
    public $kirpejai_table = "tb_kirpejai";
    public $klientai_table = "tb_klientai";
    public $rezervacijos_table = "tb_rezervacijos";

    protected $connection;

    function __construct()
    {

    }

    public function connect() {
        /*$pdo = new PDOConnector(
            DB_HOST, // server
            DB_USER,      // user
            DB_PASS,      // password
            DB_DATABASE   // database
        );

        $pdoConn = $pdo->connect('utf8', []); // charset, options

        $dbConn = new Mysql($pdoConn);

        return $dbConn;*/

        /*$db_class = new MeekroDB();

        $host = DB_HOST;
        $db   = DB_DATABASE;
        $user = DB_USER;
        $pass = DB_PASS;
        $charset = 'utf8mb4';

        $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, $user, $pass, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }

        return $pdo;*/

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
        if (!$sql || mysqli_num_rows($sql) == 0) {
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

        $text = str_replace(['%', '´'], ['', ''], $text);
        if (!get_magic_quotes_gpc()) {
            $text = addslashes($text);
        }
        $text=mysqli_real_escape_string($conn,$text);
        return $text;
    }
}