<?php

class Application {    
    public static function processPost(){
        $query = "INSERT INTO applications (username, country, year, heard, email, comment) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("ssisss", $_POST['username'], $_POST['country'], $_POST['year'], $_POST['heard'], $_POST['email'], $_POST['comment']);
        $stmt->execute();
    }
}
