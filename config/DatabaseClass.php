<?php

class DatabaseClass {

 
    public function __construct()  
    {  
        $connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,DB_DATABASE);
        if ($connection->connect_error) {
            echo "Failed to connect to MySQL: " . $mysqli -> connect_error;
            exit();
        }
        return $this->connection = $connection;
    }



}