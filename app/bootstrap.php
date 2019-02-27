<?php

namespace kirpykla_dev;

use kirpykla_dev\Controllers\KirpejaiController;

define('BASE', __DIR__);
define('BASE_URI', 'localhost/kirpykla_dev/public/');


//load all our classes as we instantiate them following the guidance of the name spaces.
spl_autoload_register(function($class) {
//    echo "<br><b>$class</b> - ".str_replace(['kirpykla_dev', '\\'], ['', '/'], $class)."<br>";
    require_once __DIR__ . str_replace(['kirpykla_dev', '\\'], ['', '/'], $class) . '.php';
});

// include the composer autoloader
require 'vendor/autoload.php';

$qs = $_SERVER['QUERY_STRING'];

if(!empty($qs)) {
    parse_str($qs, $qs_array);
}
$ps_array = $_POST;
$method = !empty($_POST) ? 'POST' : 'GET';

//primitive routing
//print_r($qs_array);
switch ($qs_array['page']) {
    case ('kirpejai_list'):
        $buff = new Controllers\KirpejaiController($qs_array['page'], $qs_array);
        break;
    case ('check_registration_valid'):
        $buff = new Controllers\RezervacijosController($qs_array['page'], $qs_array);
        break;
    case ('new_kirpejo_rezervacija'):
        $buff = new Controllers\KirpejaiController($qs_array['page'], $qs_array);
        break;
    case ('new_kirpejo_rezervacija_save'):
        $buff = new Controllers\RezervacijosController($qs_array['page'], $qs_array);
        break;
    case ('cancel_kirpejo_rezervacija'):
        $buff = new Controllers\RezervacijosController($qs_array['page'], $qs_array);
        break;

    case ('kliento_puslapis'):
        $buff = new Controllers\RezervacijosController($qs_array['page'], $qs_array);
        break;

    default:
        new Controllers\IndexController();
        break;
}
