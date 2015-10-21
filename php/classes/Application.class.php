<?php

class Application {
    public static function processPost(){
        
        $profile = ProfileUtils::getProfile($_POST['username']);
        if($profile == null)
            return false;
        $result = $profile->getProfileAsArray();
        $uuid = $result['uuid'];
        $username = $result['username'];
        
        $query = "INSERT INTO applications (uuid, username, country, year, heard, email, comment) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("sssisss", $uuid, $username, $_POST['country'], $_POST['year'], $_POST['heard'], $_POST['email'], $_POST['comment']);
        $stmt->execute();
        return true;
    }
}
