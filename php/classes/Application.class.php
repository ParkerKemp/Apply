<?php

class Application {
    public static function processPost(){
        
        $user = User::fromUsername($_POST['username']);
        $uuid = $user->uuid;
        $username = $user->username;
        
//        $profile = ProfileUtils::getProfile($_POST['username']);
//        if($profile == null)
//            return false;
//        $result = $profile->getProfileAsArray();
//        $uuid = $result['uuid'];
//        $username = $result['username'];
        
        $query = "INSERT INTO applications (uuid, username, country, year, heard, comment) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("sssiss", $uuid, $username, $_POST['country'], $_POST['year'], $_POST['heard'], $_POST['comment']);
        $stmt->execute();
        
        $query = "INSERT INTO pendingNotification (uuid) VALUES (?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("s", $uuid);
        $stmt->execute();
        
        if($_POST['heard'] == 'players' && isset($_POST['referrers'])){
            static::handleReferrers($uuid, $_POST['referrers']);
        }
        
        static::whitelistAdd($username);
        return true;
    }
    
    private static function handleReferrers($playerUuid, $referrersString){
        $referrers = explode(',', $referrersString);
        foreach($referrers as $key => $value){
            $referrers[$key] = trim($value);
        }
        foreach($referrers as $username){
            $user = User::fromUsername($username);
            if($user != null){
                $referrerUuid = $user->uuid;
                static::insertReferrer($playerUuid, $referrerUuid);
            }
        }
    }
    
    private static function insertReferrer($player, $referrer){
        $query = "INSERT INTO referredPlayers (player, referrer) VALUES "
                . "(?, ?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("ss", $player, $referrer);
        $stmt->execute();
    }
    
    private static function sendCommand($command){
        $socket = fsockopen("unix:///home/minecraft/server/spinal/plugins/Spinalpack/sockets/command.sock");
        
        if(fwrite($socket, $command) === false)
            return false;
        fclose($socket);
        return true;
    }
    
    private static function whitelistAdd($username){
        static::sendCommand("pex user $username group add user");
        static::sendCommand("whitelist add $username");
    }
}
