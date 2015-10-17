<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body>
<?php

require_once('AutoLoad.php');

echo getHeaders();

echo getForm();

function getForm(){
    $div = '<div class="outer"><div class="middle"><div class="inner">';
    $div .= '<form id="registrationForm" action="" method="POST">';

    $div .= 'What is your Minecraft username? <input id="username" type="text" name="username"></input><br><br>';
    $div .= 'What country are you playing from? <input id="country" type="text" name="country"></input><br><br>';
    $div .= 'What year were you born? <select id="year" name="year"><option value="">Choose one</option></select><br><br>';
    $div .= 'How did you hear about Spinalcraft? <input id="heard" type="text" name="heard"></input><br><br>';

    $div .= '<input id="submitButton" type="button" value="Submit"></input>';

    $div .= '</form></div></div></div>';
    return $div;
}

function getHeaders(){
    $headers = Utils::cssTag("css/apply.css");
    $headers .= Utils::jsTag("js/jquery/jquery.min.js");
    $headers .= Utils::jsTag("js/apply.js");
    return $headers;
}

?>
    </body>
</html>
