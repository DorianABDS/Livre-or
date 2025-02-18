<?php

// Database class to handle database connection
class Database
{
    protected $db;

    // Constructor to establish the database connection
    public function __construct()
    {
         $servername = 'localhost';
         $username = 'root';
         $password = "";
         $dbname = "livreor";

        try {
        $this->db = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

}