<?php

class Database
{
    private static $dbhost = "localhost";
    private static $dbname = "burger_code";
    private static $dbUser = "root";
    private static $dbUserPassword = "";

    private static $connection = null;

    public static function connect()
    {
    try
    {
        // Je met le préfixe self:: afin d'appeler en private via PDO
        self::$connection = new PDO("mysql:host=" . self::$dbhost . ";dbname=" . self::$dbname,self::$dbUser,self::$dbUserPassword);
    }
    catch (PDOException $e)
    {
        die($e->getMessage());
    }

    return self::$connection;
}

    public static function  disconnect ()
    {
        $connection = null;
    }
}

// Pour vérifier notre connexion à notre BDD en PDO
//    Database::connect();




?>