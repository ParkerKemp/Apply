<?php

class Application {
    public static function processPost(){
        
        $user = User::fromUsername($_POST['username']);
        if($user == null)
            return false;
        $uuid = $user->uuid;
        $username = $user->username;
        
        $query = "INSERT INTO applications (uuid, username, country, year, heard, comment) VALUES (?, ?, ?, ?, ?, ?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("sssiss", $uuid, $username, $_POST['country'], $_POST['year'], $_POST['heard'], $_POST['comment']);
        $success = $stmt->execute();
        if(!$success)
          return false;
        
//        $query = "INSERT INTO pendingNotification (uuid) VALUES (?)";
//        $stmt = Database::getInstance()->prepare($query);
//        $stmt->bind_param("s", $uuid);
//        $stmt->execute();
        
        if($_POST['heard'] == 'players' && isset($_POST['referrers'])){
            static::handleReferrers($uuid, $_POST['referrers']);
        }
        
        static::whitelistAdd($username);
        static::announcePlayer($uuid);
        static::promotePlayer($username);
        return true;
    }
    
    private static function handleReferrers($playerUuid, $referrersString){
        $referrers = explode(',', $referrersString);
        foreach($referrers as $key => $value){
            $referrers[$key] = trim($value);
        }
        foreach($referrers as $username){
            $user = User::fromUsername($username);
            $referrerUuid = $user->uuid;
            static::insertReferrer($playerUuid, $referrerUuid);
        }
    }
    
    private static function insertReferrer($player, $referrer){
        $query = "INSERT INTO referredPlayers (player, referrer) VALUES "
                . "(?, ?)";
        $stmt = Database::getInstance()->prepare($query);
        $stmt->bind_param("ss", $player, $referrer);
        $stmt->execute();
    }
    
    private static function whitelistAdd($username){
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
	socket_set_block($socket);
        socket_connect($socket, EnvironmentVars::getSocketPath());
        
        if(socket_write($socket, "whitelist add $username") === false)
            ;//Socket error?
    }
    
    private static function announcePlayer($uuid){
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
	socket_set_block($socket);
        socket_connect($socket, EnvironmentVars::getSocketPath());
        
        if (socket_write($socket, "__announce__ $uuid") === false)
            ;//Socket error?
    }
    
    private static function promotePlayer($username){
        $socket = socket_create(AF_UNIX, SOCK_STREAM, 0);
	socket_set_block($socket);
        socket_connect($socket, EnvironmentVars::getSocketPath());
        
        if (socket_write($socket, "pex promote $username automatic") === false)
            ;//Socket error?
    }
}
