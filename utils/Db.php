<?php

/**
 * Db singleton class 
 */
class Db
{
    private static $instance;
    private function __construct()
    {
        $config = require_once("utils/config.php");
        [$host, $username, $password, $dbName] =  [$config['db']["host"], $config['db']["username"], $config['db']["password"], $config['db']["dbName"]];
        $conn = new mysqli($host, $username, $password, $dbName);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        self::$instance = $conn;
    }
    public static function getInstance()
    {
        if (!isset(self::$instance)) {
            new Db();
        }
        return self::$instance;
    }
}
