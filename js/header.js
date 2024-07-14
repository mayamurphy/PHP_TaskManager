$(function() {
    $("#menu-container").mouseover(function() {
        $("#menu").css("display","block");
    })

    $("#menu-container").mouseout(function() {
        $("#menu").css("display","none");
    })
})