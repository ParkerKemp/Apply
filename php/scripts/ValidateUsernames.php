<?php

$usernames = $_POST['usernames'];

foreach($usernames as $username){
    if(!validate($username)){
        invalidUsername($username);
        die();
    }
}

valid();

function validate($username){
    $user = User::fromUsername($username);
    return $user != null;
//    $profile = ProfileUtils::getProfile($username);
//    if($profile != null){
//        $result = $profile->getProfileAsArray();
//        return $result != null;
//    }
//    else
//        return false;
}

function invalidUsername($username){
    $arr = array('status' => 'bad', 'username' => $username);
    echo json_encode($arr);
}

function valid(){
    $arr = array('status' => 'good');
    echo json_encode($arr);
}