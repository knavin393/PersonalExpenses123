<?php

class Config
{

    private $host = 'localhost';
    private $db = 'star';
    private $dsn = '';
    private $username = 'root';
    private $password = '';
    private $conn = null;

    function __construct()
    {
        $this->dsn = "mysql:host = $this->host;dbname=" . $this->db;
    }

    // get the database connection
    public function getConnection()
    {

        $this->conn = null;

        try {
            $this->conn = new PDO($this->dsn, $this->username, $this->password);
            // set the PDO error mode to exception
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $exception) {
            echo "<div class='btn btn-info'>Oops! Something went wrong somewhere.</br></br><b>Please Consult Administrator for assistance</b></br></br>Thank You!</div>";
        }

        return $this->conn;
    }

    function getHost()
    {
        return $this->host;
    }

    function getDb()
    {
        return $this->db;
    }

    function getUsername()
    {
        return $this->username;
    }

    function getPassword()
    {
        return $this->password;
    }
}


?>