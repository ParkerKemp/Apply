<?php

class Database {
    private static $instance;
    private $conn;
    
    private function __construct(){
        $this->conn = new mysqli('localhost', 'root', 'password');
        $this->connect();
        $this->createTables();
    }
    
    public static function getInstance(){
        if(!static::$instance){
            static::$instance = new Database();
        }
        return static::$instance;
    }
    
    private function connect(){
        $this->conn->select_db(EnvironmentVars::getDatabaseName());
    }
    
    private function createTables(){
        $query = "CREATE TABLE IF NOT EXISTS applications (uuid VARCHAR(32) PRIMARY KEY, username VARCHAR(32), "
                . "country VARCHAR(64), year INT, heard VARCHAR(32), comment MEDIUMTEXT, status INT DEFAULT 0, "
                . "staffActor VARCHAR(32), actionTimestamp TIMESTAMP NULL, timestamp TIMESTAMP DEFAULT CURRENT_TIMESTAMP, announced TINYINT NOT NULL DEFAULT 0)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        
        $query = "CREATE TABLE IF NOT EXISTS referredPlayers (id INT AUTO_INCREMENT PRIMARY KEY, player VARCHAR(32) NOT NULL, referrer VARCHAR(32) NOT NULL)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
    }
    
    public function prepare($query){
        return $this->conn->prepare($query);
    }
    
    public function lastError(){
        echo $this->conn->error;
    }
}
