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
});

$(function() {
    $("#login-form").submit(function() {
        var values = $("#login-form").serialize();
        $.ajax ({
            type: "POST",
            url: "handlers/login_handler.php",
            data: values,
            success: function() {
                // window.location.href = "todo.php";
                alert("LOGIN SUCCESS");
                return false;
            },
            error: function() {
                alert("LOGIN FAILURE"+values);
            }
        });
        return false;
    });
});

$(function() {
    $("#signup-form").submit(function() {
        var values = $("#signup-form").serialize();

        var username = document.getElementById("signup-un").value;
        var password = document.getElementById("signup-pw").value;
        var confirm_password = document.getElementById("signup-confirm-pw").value;

        if ("" === username) {
            $("<div id='error-messages'>Username not entered.</div>").insertBefore("#signup-form");
        }
        if ("" === password || "" === confirm_password) {
            $("<div id='error-messages'>Password not entered.</div>").insertBefore("#signup-form");
            return false;
        }
        else if (password !== confirm_password) {
            $("<div id='error-messages'>Passwords do not match.</div>").insertBefore("#signup-form");
            return false;
        }
        else {
            alert("ajax");
            $.ajax ({
                type: "POST",
                url: "handlers/signup_handler.php",
                data: values,
                success: function() {
                    window.location.href = "index.php";
                },
                error: function(response) {
                    alert(response);
                    alert("SIGNUP FAILURE");
                }
            });
            return false;
        }
    });
});

function signupValidation() {
    var username = document.getElementById("signup-un").value;
    var password = document.getElementById("signup-pw").value;
    var confirm_password = document.getElementById("signup-confirm-pw").value;

    if (1 > username.length || 64 < username.length) {
        $("#signup-un").css("border-color", "#F00");
        console.log(username);
    } else {
        $("#signup-un").css("border-color", "#FFF");
    }

    if (8 > password.length) {
        $("#signup-pw").css("border-color", "#F00");
    }
    else {
        $("#signup-pw").css("border-color", "#FFF");
    }

    if (confirm_password !== password) {
        $("#signup-confirm-pw").css("border-color", "#F00");
    }
    else {
        $("#signup-confirm-pw").css("border-color", "#FFF");
    }
}