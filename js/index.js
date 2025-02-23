// move slider / switch form
$(function() {
    $("#signup-page").click(function() {
        $("#signup-page").css("background-color","#7E9971");
        $("#login-page").css("background-color","transparent");
        $(".signup-form-container").css("display","block");
        $(".login-form-container").css("display","none");
    });

    $("#login-page").click(function() {
        $("#login-page").css("background-color","#7E9971");
        $("#signup-page").css("background-color","transparent");
        $(".login-form-container").css("display","block");
        $(".signup-form-container").css("display","none");
    });
});

// switch to signup page if username is taken
$(function() {
    if (0 < $("#error-messages-un-taken").length) {
        $("#signup-page").css("background-color","#7E9971");
        $("#login-page").css("background-color","transparent");
        $(".signup-form-container").css("display","block");
        $(".login-form-container").css("display","none");
        $("#signup-un").css("border-color", "#F00");
    }

    if (0 < $("#error-messages-invalid-login").length) {
        $("#login-page").css("background-color","#7E9971");
        $("#signup-page").css("background-color","transparent");
        $(".login-form-container").css("display","block");
        $(".signup-form-container").css("display","none");
        $("#login-un").css("border-color", "#F00");
        $("#login-pw").css("border-color", "#F00");
        $("#error-messages-invalid-login").css("color","#F00");
    }
});

// AJAX submit
$(function() {
    $("#signup-form").submit(function() {
        var values = $("#signup-form").serialize();

        var username = $("#signup-un").val().trim();
        var password = $("#signup-pw").val();
        var confirm_password = $("#signup-pw").val();
        var sqq1 = $("#signup-sqq1").val();
        var sqa1 = $("#signup-sqa1").val();
        var sqq2 = $("#signup-sqq2").val();
        var sqa2 = $("#signup-sqa2").val();
        var sqq3 = $("#signup-sqq3").val();
        var sqa3 = $("#signup-sqa3").val();

        if ("" === username) {
            if (0 === $("#error-messages-un").length) {
                $("<div id='error-messages-un'>Username must be 1-64 characters long.</div>").insertBefore("#signup-form");
                $("#error-messages-un").css("color", "#F00");
                $("#signup-un").css("border-color", "#F00");
            }
            return false;
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

        if (8 > password.length) {
            if (0 === $("#error-messages-pw").length) {
                $("<div id='error-messages-pw'>Password should be at least 8 characters.</div>").insertBefore("#signup-form");
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
$(function () {
    // prevent form submit on enter
    $("#signup-form").on("keydown", function(e) {
        return e.key != "Enter";
    });

    $("#signup-un").on("keyup", function() {
        // check if username meets character length
        var un = $("#signup-un").val().trim();
        if (0 > un.length || 64 < un.length) {
            $("#signup-un").css("border-color", "#F00");
        } else {
            $("#signup-un").css("border-color", "#FFF");
        }
    });

    $("#signup-pw").on("keyup", function() {
        // check if password meets criteria
        if (8 > $("#signup-pw").val().length) {
            $("#signup-pw").css("border-color", "#F00");
        }
        else {
            $("#signup-pw").css("border-color", "#FFF");
        }
    });
    
    $("#signup-confirm-pw").on("keyup", function() {
        // check if passwords match
        if ($("#signup-confirm-pw").val() !== $("#signup-pw").val() || 8 > $("#signup-confirm-pw").val().length) {
            $("#signup-pw").css("border-color", "#F00");
            $("#signup-confirm-pw").css("border-color", "#F00");
        }
        else {
            $("#signup-pw").css("border-color", "#FFF");
            $("#signup-confirm-pw").css("border-color", "#FFF");
        }
    });

    // enable "next" button to continue to security questions
    $("#signup-un-pw").on("keyup", function() {
        var un = $("#signup-un").val().trim();
        var pw = $("#signup-pw").val();
        var cpw = $("#signup-confirm-pw").val();

        if ((0 < un.length && 64 > un.length) && 
            (8 <= pw.length) &&
            (cpw === pw && 8 <= cpw.length)) {
            $("#next-button").prop("disabled",false);
        }
    });

    // display security questions when "next" button is clicked
    $("#next-button").click(function() {
        $("#signup-un-pw").css("display", "none");
        $("#signup-sq").css("display", "block");
    });
});