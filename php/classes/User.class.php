<?php

class User {
    public $username, $uuid;
    
    public static function fromUsername($username){
        return static::fromUuid($username); //same code
    }
    
    public static function fromUuid($uuid){
        $profile = ProfileUtils::getProfile($uuid);
        if($profile == null)
            return null;
        $result = $profile->getProfileAsArray();
        if($result == null)
            return null;
        
        $return = new static();
        $return->uuid = $result['uuid'];
        $return->username = $result['username'];
        return $return;
    }
}
