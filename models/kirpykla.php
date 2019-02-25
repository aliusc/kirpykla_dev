<?php
class Kirpykla
{
    public $pdo;

    public function __construct(){
        $dsn = sprintf('mysql:host=%s;dbname=%s;charset=%s', DB_HOST, DB_DATABASE, DB_CHARSET);
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
            $this->pdo = $pdo;
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }

    public function GetKirpejos() {
        $result = $this->pdo->query("SELECT * FROM tb_kirpejai")->fetchAll(PDO::FETCH_ASSOC);
        return $result;
    }

    public function GetKirpejosDay($kirpejo_id, $data) {
        $sql = $this->pdo->prepare('SELECT rezervacijos_kirpejo_id, rezervacijos_laikas FROM tb_rezervacijos WHERE rezervacijos_kirpejo_id = ? AND rezervacijos_data = ? AND rezervacijos_aktyvus = ? ORDER BY rezervacijos_laikas ASC');
        $sql->execute([$kirpejo_id, $data, '1']);
        return $sql->fetchAll(PDO::FETCH_ASSOC);
    }

    public function SetRezervacija($kirpejo_id, $data, $laikas, $klientas) {

    }
}