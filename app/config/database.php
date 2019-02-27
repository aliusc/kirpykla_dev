<?php

if($_SERVER['SERVER_ADDR'] == '127.0.0.1') {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');
    define('DB_DATABASE', 'kirpykla');
    define('DB_CHARSET', 'utf8_binnacry_ci');
}
else {
    $url = parse_url(getenv("CLEARDB_DATABASE_URL"));
    define('DB_HOST', $url["host"]);
    define('DB_USER', $url["user"]);
    define('DB_PASS', $url["pass"]);
    define('DB_DATABASE', substr($url["path"], 1));
    define('DB_CHARSET', 'utf8_binnacry_ci');
    print_r($url);
}