<?php

class User {
    public $username, $uuid;
    
    public static function fromUsername($username){
        return static::fromProfile(ProfileUtils::getProfileFromUsername($username));
    }
    
    public static function fromUuid($uuid){
        return static::fromProfile(ProfileUtils::getProfileFromUuid($uuid));
    }
    
    private static function fromProfile($profile){
        if($profile == null)
            return null;
        $result = $profile->getProfileAsArray();
        $return = new static();
        $return->uuid = $result['uuid'];
        $return->username = $result['username'];
        return $return;
    }
}
