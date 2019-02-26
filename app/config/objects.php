<?php

class Klientas {

    public $id;
    public $vardas;

    public function __construct($id, $vardas)
    {
        $this->id = $id;
        $this->vardas = $vardas;
    }

}

class Kirpejas extends Klientas {

}

class Rezervacija {

    public $id;
    public $kirpejas;
    public $klientas;
    public $date;
    public $laikas;
    public $aktyvus;

    /**
     * Rezervacija constructor.
     * @param $id
     * @param $kirpejas
     * @param $klientas
     * @param $date
     * @param $laikas
     * @param $aktyvus
     */
    public function __construct($id, $kirpejas, $klientas, $date, $laikas, $aktyvus = true)
    {
        $this->id = $id;
        $this->kirpejas = $kirpejas;
        $this->klientas = $klientas;
        $this->date = $date;
        $this->laikas = $laikas;
        $this->aktyvus = $aktyvus;
    }

}
