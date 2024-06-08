<?php

class Database {
    private $servername;
    private $username;
    private $password;
    private $dbName;
    private $conn;

    public function __construct($servername, $username, $password, $dbName) {
        $this->servername = $servername;
        $this->username = $username;
        $this->password = $password;
        $this->dbName = $dbName;
    }

    public function connect() {
        $this->conn = new mysqli($this->servername, $this->username, $this->password, $this->dbName);
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
        echo "";
    }

    public function getConnection() {
        return $this->conn;
    }
}

// Iniciácia databázového pripojenia
$database = new Database("localhost", "root", "", "ancient");
$database->connect();
$conn = $database->getConnection();
?>
