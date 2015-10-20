<?php

$username = $_POST['username'];

$profile = ProfileUtils::getProfile($username);
if($profile != null){
    $result = $profile->getProfileAsArray();
    print_r($result);
    if($result == null)
        echo "bad";
    else
        echo "good";
}
else
    echo "bad";