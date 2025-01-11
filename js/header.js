$(function() {
    $("#menu-container").mouseover(function() {
        $("#menu").css("display","block");
    })

    $("#menu-container").mouseout(function() {
        $("#menu").css("display","none");
    })

    var perc = parseInt(document.getElementById("progress-percent").innerHTML, 10);
    var width = Math.ceil(perc / 5) * 5;        // round to nearest 5%
    if (width > 100) { width = 100; }           // don't allow progress bar to exceed 100%
    $("#progress-percent").html(perc);          // update percent
    $("#progress").css("width", width+"%");
})