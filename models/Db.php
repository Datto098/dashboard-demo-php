<?php
class Db
{
    public static $connection;
    public function __construct()
    {
        if (!self::$connection) {
            self::$connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME,PORT);
            self::$connection->set_charset(DB_CHARSET);
        }
        return self::$connection;
    }
}