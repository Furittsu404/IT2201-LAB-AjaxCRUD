<?php
class Connection {
    
    private $DAddress = "localhost";
    private $DUsername = "root";
    private $DPass = "";
    private $DName = "uts_db";

    public function connect() {
        $conn = new mysqli($this->DAddress, $this->DUsername, $this->DPass, $this->DName);
        
        if ($conn->connect_error) {
            die("Connection failed: ". $conn->connect_error);
        }
        else {
            return $conn;
        }
    }
}