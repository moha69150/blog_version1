<?php

define('DB_SERVER', '127.0.0.1');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', 'Dwwm_2023');
define('DB_NAME', 'blog');

try {
    $pdo = new PDO("mysql:host=". DB_SERVER . ":3308;dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD,[
        PDO::ATTR_ERRMODE => PDO:: ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
    ]);
        

    // // check connection status
    // echo $pdo->getAttribute(PDO::ATTR_CONNECTION_STATUS);
} catch(Exception $e) {
    echo $e->getMessage();
    die("ERREUR : Impossible de se connecter. ");
}

return $pdo;