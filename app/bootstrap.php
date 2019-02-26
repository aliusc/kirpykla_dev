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
$method = !empty($_POST) ? 'POST' : 'GET';

//primitive routing

switch ($qs_array['page']) {
    case ('kirpejai_list'):
        $buff = new Controllers\KirpejaiController($qs_array['page']);

        break;
    case ('/about'):
        $buff = new Controllers\AboutController([
            BASE . '/Views/default.php'
        ]);
        break;
    default:
        new Controllers\IndexController();
        break;
}
