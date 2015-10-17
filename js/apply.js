$(document).ready(function(){
    populateYearInput();
    $('#submitButton').click(function(e){
        $(".error").remove();
        if(!validateForm())
            return;

        $("#registrationForm").submit();
    });
});

function validateForm(){
    var good = true;
    
    good &= validateUsername();
    good &= validateCountry();
    good &= validateYear();
    good &= validateHeard();
    good &= validateEmail();
    
    return good;
}

function validateUsername(){
    var username = $("#username").val();
    if(username === ""){
        validationError(document.getElementById("username"), "Please enter a valid username.");
        return false;
    }
    return true;
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
    var heard = $("#year").val();
    if(heard === ""){
        validationError(document.getElementById("heard"), "Please choose an answer.");
        return false;
    }
    return true;
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
    
    form.insertBefore(error, input);
}