/*
|---------------------------
| Submit form on CTRL+s
|---------------------------
*/
$(window).keypress(function(event) {
    if (!(event.which == 115 && event.ctrlKey) && !(event.which == 19)) return true;
    $("#submit-btn").click();
    event.preventDefault();
    return false;
});