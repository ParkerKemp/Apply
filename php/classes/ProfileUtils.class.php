<?php

/* The MIT License (MIT)
 *   
 * Copyright (c) 2014 Daniel Fanara
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy of 
 * this software and associated documentation files (the "Software"), to deal in the 
 * Software without restriction, including without limitation the rights to use, copy, 
 * modify, merge, publish, distribute, sublicense, and/or sell copies of the Software, 
 * and to permit persons to whom the Software is furnished to do so, subject to the 
 * following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all 
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, 
 * INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A 
 * PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT 
 * HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER IN AN ACTION 
 * OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE 
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 */

/*
 * Example of using the Classes.
 */

//$profile = ProfileUtils::getProfile("Shadowwolf97");
//if ($profile != null) {
//  $result = $profile->getProfileAsArray();
//  echo 'username: '.$result['username'].'<br>';
//  echo 'uuid: '.$result['uuid'].'<br/>';
//}
////I am honestly not sure what the properties are at this point, but I included them just in case they are needed.
////echo 'properties: '.$result['properties'].'<br />';
//$profile = ProfileUtils::getProfile("c465b1543c294dbfa7e3e0869504b8d8");
//if ($profile != null) {
//  $result = $profile->getProfileAsArray();
//  echo 'username: '.$result['username'].'<br>';
//  echo 'uuid: '.$result['uuid'].'<br/>';
//}
/*
 * * * * * * * * * * * * * * * * * * * * * * * * * * *
 *                    OutPuts                        *
 * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * username: Shadowwolf97
 * uuid: 795a605316a742f2bdd29e8e33ff0333
 * username: turt2live
 * uuid: c465b1543c294dbfa7e3e0869504b8d8
 */
class MinecraftProfile {

    private $username;
    private $uuid;

    /**
     * @param string $username The player's username.
     * @param string $uuid The player's UUID.
     */
    function __CONSTRUCT($username, $uuid) {
        $this->username = $username;
        $this->uuid = $uuid;
    }

    /**
     * @return string The player's username.
     */
    public function getUsername() {
        return $this->username;
    }

    /**
     * @return string The player's UUID.
     */
    public function getUUID() {
        return $this->uuid;
    }

    /**
     * @return array Returns an array with keys of 'properties, usernname and uuid'.
     */
    public function getProfileAsArray() {
        return array("username" => $this->username, "uuid" => $this->uuid);
    }

}

class ProfileUtils {

    /**
     * @param string $identifier Either the player's Username or UUID.
     * @param int $timeout The length in seconds of the http request timeout.
     * @return MinecraftProfile|null Returns null if fetching of profile failed. Else returns completed user profile.
     */
    public static function getProfile($identifier, $timeout = 5) {
        if (strlen($identifier) <= 16) {
            $uuid = ProfileUtils::getUUIDFromUsername($identifier, $timeout);
            if ($uuid == null)
                return null;
        } else {
            $uuid = $identifier;
        }

        $url = "https://api.mojang.com/user/profiles/$uuid/names";
        $ret = file_get_contents($url);
        if (isset($ret) && $ret != null && $ret != false) {
            $data = json_decode($ret, true);
            $profileData = $data[count($data) - 1];
            return new MinecraftProfile($profileData['name'], $uuid);
        } else {
            return null;
        }
    }

    /**
     * @param $username string Minecraft username.
     * @param int $timeout http timeout in seconds
     * @return array (Key => Value) "username" => Minecraft username (properly capitalized) "uuid" => Minecraft UUID
     */
    public static function getUUIDFromUsername($username) {
        if (strlen($username) > 16)
            return array("username" => "", "uuid" => "");
        $url = 'https://api.mojang.com/users/profiles/minecraft/' . $username;
        if (static::get_http_response_code($url) != "200") {
            return null;
        }
        $result = file_get_contents($url);
        // Verification
        if (isset($result) && $result != null && $result != false) {
            $ress = json_decode($result, true);
            return $ress['id'];
        } else
            return null;
    }

    /**
     * @param $uuid string UUID to format
     * @return string Properly formatted UUID (According to UUID v4 Standards xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx WHERE y = 8,9,A,or B and x = random digits.)
     */
    public static function formatUUID($uuid) {
        $uid = "";
        $uid .= substr($uuid, 0, 8) . "-";
        $uid .= substr($uuid, 8, 4) . "-";
        $uid .= substr($uuid, 12, 4) . "-";
        $uid .= substr($uuid, 16, 4) . "-";
        $uid .= substr($uuid, 20);
        return $uid;
    }

    private static function get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }

}
