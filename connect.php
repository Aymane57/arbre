<?php

define('DB_HOST', 'localhost'); # Le serveur de la base
define('DB_PORT', '3306'); # Le Port
define('DB_USER', 'root'); # L'utilisateur
define('DB_PASS', ''); # Le mot de pass
define('DB_NAME', 'arbre'); # Le nom de la base de données

class Connect {

    static function getInstance() {
        $db = new PDO('mysql:host = ' . DB_HOST . ':' . DB_PORT . '; dbname=' . DB_NAME, DB_USER, DB_PASS);

        $db->exec("SET CHARACTER SET utf8");
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $db;
    }

}

?>
