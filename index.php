<?php

require_once 'AutoLoad.php';

if(isset($_POST['redirectFilename'])){
    require_once $_POST['redirectFilename'];
    die();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
    </head>
    <body background="resources/background2.jpg" style="background-size: 1920px 1080px; background-repeat: no-repeat;">

<?php

echo getHeaders();

if(isset($_POST['username'])){
    if(Application::processPost()){
        echo "Thanks for registering! You should be able to log into the server now.";
        echo "<br>";
        echo "Server address: mc.spinalcraft.com";
        echo "<br>";
        echo '<a href="http://www.reddit.com/r/spinalcraft">Back to the subreddit</a>';
    }
    else
        echo "Something went wrong! You may have submitted an invalid username, or a username that was already registered. Please try again.";
}
else{
    echo getForm();
}

function getForm(){
    $div = '<div class="outer"><div class="middle"><div class="inner">';
    $div .= '<form id="registrationForm" action="" method="POST">';

    $div .= 'What is your Minecraft username?* <input id="username" type="text" name="username"></input><br><br>';
    $div .= 'What country are you playing from?* <input id="country" type="text" name="country"></input><br><br>';
    $div .= 'What year were you born?* <br><select id="year" name="year" style="max-width: 100px"><option value="">Choose one</option></select><br><br>';
    $select = '<select id="heard" name="heard" style="max-width: 400px">'
            . '<option value="">Choose one</option>'
            . '<option value="mcsl">Minecraft Server List</option>'
            . '<option value="pmc">Planet Minecraft</option>'
            . '<option value="reddit">Reddit</option>'
            . '<option value="players">Other Player(s)</option>'
						. '<option value="other">I was just typing random strings of characters into the address bar and now I\'m here</option>'
            . '<option value="other">Other</option>'
            . '</select>';
    $div .= "Where did you hear about Spinalcraft?* $select<br><br>";
//    $div .= 'Email address: <br><font size="1">(For notification only)</font> <input id="email" type="text" name="email"></input><br><br>';
    $div .= '<p id="referrersP" style="display:none;">List any players who referred you to Spinalcraft (comma separated): <input id="referrers" type="text" name="referrers"></input><br><br></p>';
    $div .= 'Tell us something about yourself: <br> <textarea name="comment" style="width: 400px; padding: 0px;"></textarea>';

    $div .= '<input id="submitButton" type="button" value="Submit" style="width: 400px;"></input>';

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
