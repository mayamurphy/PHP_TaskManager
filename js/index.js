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

// switch to signup page if username is taken
$(function() {
    if (0 < $("#error-messages-un-taken").length) {
        alert("error-messages-un-taken");
        $("#signup-page").css("background-color","#FAF");
        $("#login-page").css("background-color","transparent");
        $(".signup-form-container").css("display","block");
        $(".login-form-container").css("display","none");
        $("#signup-un").css("border-color", "#F00");
    }

    if (0 < $("#error-messages-invalid-login").length) {
        alert("error-messages-invalid-login");
        $("#login-page").css("background-color","#FAF");
        $("#signup-page").css("background-color","transparent");
        $(".login-form-container").css("display","block");
        $(".signup-form-container").css("display","none");
        $("#login-un").css("border-color", "#F00");
        $("#login-pw").css("border-color", "#F00");
        $("#error-messages-un-taken").css("color","#F00");
    }
});

// AJAX submit
$(function() {
    $("#login-form").submit(function() {
        var values = $("#login-form").serialize();
        $.ajax ({
            type: "POST",
            url: "handlers/login_handler.php",
            data: values,
            success: function() {
                window.location.href = "todo.php";
            },
            error: function() {
                alert("LOGIN FAILURE");
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
            if (0 === $("#error-messages-un").length) {
                $("<div id='error-messages-un'>Username must be 1-64 characters long.</div>").insertBefore("#signup-form");
                $("#error-messages-un").css("color", "#F00");
                $("#signup-un").css("border-color", "#F00");
            }
        }
        else {
            $("div").remove("#error-messages-un");
            $("#signup-un").css("border-color", "#FFF");
        }

        if ("" === password) {
            if (0 === $("#error-messages-pw").length) {
                $("<div id='error-messages-pw'>Password not entered.</div>").insertBefore("#signup-form");
                $("#error-messages-pw").css("color", "#F00");
                $("#signup-pw").css("border-color", "#F00");
            }
            return false;
        }
        else {
            $("div").remove("#error-messages-pw");
            $("#signup-pw").css("border-color", "#FFF");
        }

        if (password !== confirm_password) {
            if (0 === $("#error-messages-confirm-pw").length) {
                $("<div id='error-messages-confirm-pw'>Passwords do not match.</div>").insertBefore("#signup-form");
                $("#error-messages-confirm-pw").css("color", "#F00");
                $("#signup-pw").css("border-color", "#F00");
                $("#signup-confirm-pw").css("border-color", "#F00");
            }
            return false;
        }
        else {
            $("div").remove("#error-messages-confirm-pw");
            $("#signup-pw").css("border-color", "#FFF");
            $("#signup-confirm-pw").css("border-color", "#FFF");
        }

        $.ajax ({
            type: "POST",
            url: "handlers/signup_handler.php",
            data: values,
            success: function() {
                window.location.href = "index.php";
            },
            error: function() {
                alert("SIGNUP FAILURE");
            }
        });
        return false;
    });
});

// Signup form validation
function signupValidation() {
    var username = document.getElementById("signup-un").value;
    var password = document.getElementById("signup-pw").value;
    var confirm_password = document.getElementById("signup-confirm-pw").value;

    // check if username meets character length
    if (1 > username.length || 64 < username.length) {
        $("#signup-un").css("border-color", "#F00");
    } else {
        $("#signup-un").css("border-color", "#FFF");
    }

    // check if password meets criteria
    if (8 > password.length) {
        $("#signup-pw").css("border-color", "#F00");
    }
    else {
        $("#signup-pw").css("border-color", "#FFF");
    }

    // check if passwords match
    if (confirm_password !== password || 8 > confirm_password.length) {
        $("#signup-pw").css("border-color", "#F00");
        $("#signup-confirm-pw").css("border-color", "#F00");
    }
    else {
        $("#signup-pw").css("border-color", "#FFF");
        $("#signup-confirm-pw").css("border-color", "#FFF");
    }
}