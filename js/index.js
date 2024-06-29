// move slider / switch form
$(document).ready(function() {
    $("#signup-page").click(function() {
        $("#signup-page").css("background-color","#FAF");
        $("#login-page").css("background-color","transparent");
        $(".signup-form-container").css("display","block");
        $(".login-form-container").css("display","none");
    });

    $("#login-page").click(function() {
        $("#login-page").css("background-color","#FAF");
        $("#signup-page").css("background-color","transparent");
        $(".login-form-container").css("display","block");
        $(".signup-form-container").css("display","none");
    });

    $("#signup-un").change(function() {
        if (1 == strlen($("#signup-un").values[0])) {
            $(this).css("background-color","#f00");
        }
    });
});

$(function() {
    $("#login-form").submit(function() {
        var values = $("#login-form").serialize();
        $.ajax ({
            type: "POST",
            url: "handlers\login_handler.php",
            data: values,
            // data: {username: values[0].value, password: values[1].value},
            success: function() {
                window.location.href = "todo.php";
            },
            error: function() {
                alert("FAILURE");
            }
        });
        return false;
    });
});

$(function() {
    $("#signup-form").submit(function() {
        var values = $("#signup-form").serialize();
        $.ajax ({
            type: "POST",
            url: "handlers\signup_handler.php",
            data: values,
            // data: {username: values[0].value, password: values[1].value, confirm_password: values[2].value},
            success: function() {
                window.location.href = "index.php";
            },
            error: function() {
                alert("FAILURE");
            }
        });
        return false;
    });
});