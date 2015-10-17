$(document).ready(function(){
    populateYearInput();
});

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