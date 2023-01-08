<?php

class DB
{
    public static $conn=null;

    public static function db()
    {
        if (DB::$conn==null) {
            $servername = 'localhost';
            $user = 'root';
            $pass = '';
            $dbname = 'my-shop';

            // Create connection
            $connection = new mysqli($servername, $user, $pass, $dbname);
            // Check connection
            if ($connection->connect_error) {
                die("Connection failed: " . $connection->connect_error);
            } else {
                // DB::$conn->connect;
                return $connection;
            }
        } else {
            return DB::$conn;
        }
    }
}