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

if(isset($_POST['username'])){
    Application::processPost();
    echo "Thanks for applying! We will review your application as soon as possible and notify you via email.";
}
else{
    echo getForm();
}

function getForm(){
    $div = '<div class="outer"><div class="middle"><div class="inner">';
    $div .= '<form id="registrationForm" action="" method="POST">';

    $div .= 'What is your Minecraft username? <input id="username" type="text" name="username"></input><br><br>';
    $div .= 'What country are you playing from? <input id="country" type="text" name="country"></input><br><br>';
    $div .= 'What year were you born? <select id="year" name="year"><option value="">Choose one</option></select><br><br>';
    $select = '<select id="heard" name="heard">'
            . '<option value="">Choose one</option>'
            . '<option value="mcsl">Minecraft Server List</option>'
            . '<option value="pmc">Planet Minecraft</option>'
            . '<option value="reddit">Reddit</option>'
            . '<option value="friend">Friend/Family</option>'
            . '<option value="other">Other</option>'
            . '</select>';
    $div .= "Where did you hear about Spinalcraft? $select<br><br>";
    $div .= 'Email address: <br><font size="1">(For notification only)</font> <input id="email" type="text" name="email"></input><br><br>';
    $div .= 'Additional comments: <br><font size="1">(optional)</font> <textarea name="comment"></textarea>';

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
