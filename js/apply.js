$(document).ready(function(){
    populateYearInput();
    $('#submitButton').click(function(e){
        $(".error").remove();
        if(!validateForm())
            return;

//        $("#registrationForm").submit();
    });
    
    $('#heard').change(function(e){
        var value = $('#heard').val();
        if(value === "players"){
            $('#referrersP').attr("style", "");
        }
        else{
            $('#referrersP').attr("style", 'display:none;');
        }
    });
});

function validateForm(){
    var good = true;
    
    good &= validateUsername();
    good &= validateCountry();
    good &= validateYear();
    good &= validateHeard();
    good &= validateReferrers();
//    good &= validateEmail();
    
    return good;
}

function validateUsername(){
    var username = $("#username").val();
    if(username === ""){
        validationError(document.getElementById("username"), "Please enter a valid username.");
        return false;
    }
    
    var good = true;
    
    $.ajax({
        async: false,
        type: "POST",
        url: "index.php",
        data: {
            redirectFilename: "php/scripts/ValidateUsernames.php",
            usernames: [username]
        },
        success: function(response){
            var json = JSON.parse(response);
            if(json.status !== "good")
                good = false;
        }
    });
    
    if(!good)
        validationError(document.getElementById("username"), "This username does not exist!");
    
    return good;
}

function validateCountry(){
    var country = $("#country").val();
    if(country === ""){
        validationError(document.getElementById("country"), "Please enter a country.");
        return false;
    }
    return true;
}

function validateYear(){
    var year = $("#year").val();
    if(year === ""){
        validationError(document.getElementById("year"), "Please choose a year.");
        return false;
    }
    return true;
}

function validateHeard(){
    var heard = $("#heard").val();
    if(heard === ""){
        validationError(document.getElementById("heard"), "Please choose an answer.");
        return false;
    }
    return true;
}

function validateReferrers(){
    var heard = $("#heard").val();
    if(heard !== "players")
        return true;
    
    var referrers = $("#referrers").val();
    var array = referrers.split(',');
    for(var key in array){
        array[key] = array[key].trim();
    }
    
    var good = true;
    var username;
    
    $.ajax({
        async: false,
        type: "POST",
        url: "index.php",
        data: {
            redirectFilename: "php/scripts/ValidateUsernames.php",
            usernames: array
        },
        success: function(response){
            var json = JSON.parse(response);
            if(json.status !== "good"){
                console.log('not good');
                good = false;
                username = json.username;
            }
        }
    });
    
    
    if(!good){
        validationError(document.getElementById("referrers"), "Username " + username + " does not exist!");
    }
    
    return good;
}

function validateEmail(){
    var email = $("#email").val();
    var regex = new RegExp("^\\w+([-+.']\\w+)*@\\w+([-.]\\w+)*\\.\\w+([-.]\\w+)*$");
    if(!regex.test(email)){
        validationError(document.getElementById("email"), "Please enter a valid email address.");
        return false;
    }
    return true;
}

function populateYearInput(){
    var date = new Date();
    var year = date.getFullYear();
    for(var i = year; i > 1900; i--){
        var option = document.createElement("option");
        $(option).val(i);
        $(option).text(i);
        $("#year").append(option);
    }
}

function validationError(input, errorMessage){
    var error = document.createElement("p");
    
    var form = document.getElementById("registrationForm");
    error.innerHTML = errorMessage;
    error.className = "error";
    
    input.parentNode.insertBefore(error, input);
}