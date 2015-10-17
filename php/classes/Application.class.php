<?php

class Application {    
    public static function processPost(){
        $query = "INSERT INTO applications (username, country, year, heard, email) VALUES (?, ?, ?, ?, ?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("ssiss", $_POST['username'], $_POST['country'], $_POST['year'], $_POST['heard'], $_POST['email']);
        $stmt->execute();
    }
}
