// AJAX Forms
$(function() {
    // prevent form submit on enter
    $("#securityQuestionsForm").on("keydown", function(e) {
        return e.key != "Enter";
    });

    // Security Questions form
    $("#securityQuestionsForm").submit(function() {
        var values = $("#securityQuestionsForm").serialize();

        var sqq1 = $("#settings-sqq1").val();
        var sqa1 = $("#settings-sqa1").val().trim();
        var sqq2 = $("#settings-sqq2").val();
        var sqa2 = $("#settings-sqa2").val().trim();
        var sqq3 = $("#settings-sqq3").val();
        var sqa3 = $("#settings-sqa3").val().trim();

        if (!sqq1 || !sqq2 || !sqq3 ) {
            $("<div id='error-messages'>Please choose a security question</div>").insertBefore("#securityQuestionsForm");
            $("#error-messages").css("color", "#F00");
            $("#settings-sqq1").css("border-color", "#F00");

            return false;
        }
        
        for (var i=1; i<4; i++) {
            if (!$("#settings-sqq"+i).val()) {
                $("#settings-sqq"+i).css("border-color","#F00");
            }
            else {
                $("#settings-sqq"+i).css("border-color", "#FFF");
            }
        }

        for (var i=1; i<4; i++) {
            if ("" === $("#settings-sqa"+i).val().trim()) {
                $("#settings-sqa"+i).css("border-color","#F00");
            }
            else {
                $("#settings-sqa"+i).css("border-color", "#FFF");
            }
        }

        if (!sqq1 || "" === sqa1 || !sqq2 || "" === sqa2 || !sqq3 || "" === sqa3) {
            return false;
        }

        $.ajax({
            type: "POST",
            url: "handlers/update_security_questions_handler.php",
            data: values,
            success: function () {

            },
            error: function () {
                alert("Failed to update security questions :(");
            }
        });
        return false;
    });

    $("#securityQuestionsForm").on("keyup", function() {
        for (var i=1; i<4; i++) {
            if (!$("#settings-sqq"+i).val()) {
                $("#settings-sqq"+i).css("border-color","#F00");
            }
            else {
                $("#settings-sqq"+i).css("border-color", "#FFF");
            }
        }

        for (var i=1; i<4; i++) {
            if ("" === $("#settings-sqa"+i).val().trim()) {
                $("#settings-sqa"+i).css("border-color","#F00");
            }
            else {
                $("#settings-sqa"+i).css("border-color", "#FFF");
            }
        }
    })

    // prevent form submit on enter
    $("#passwordResetForm").on("keydown", function(e) {
        return e.key != "Enter";
    });

    $("#passwordResetForm").submit(function() {
        var values = $("#passwordResetForm").serialize();

        var old_pw = $("#old-pw").val().trim();
        var new_pw = $("#new-pw").val().trim();
        var new_confirm_pw = $("#new-confirm-pw").val().trim();

        if (!old_pw || !new_pw || !new_confirm_pw) {
            return false;
        }

        if (8 > $("#new-pw").val().trim().length) {
            $("#new-pw").css("border-color", "#F00");
            return false;
        }
        else {
            $("#new-pw").css("border-color", "#FFF");
        }

        if (new_pw !== new_confirm_pw) {
            $("#new-pw").css("border-color", "#F00");
            $("#new-confirm-pw").css("border-color", "#F00");
            return false;
        }
        else if (new_pw === new_confirm_pw && 8 <= new_pw.length) {
            $("#new-pw").css("border-color", "#FFF");
            $("#new-confirm-pw").css("border-color", "#FFF");
        }
        
        $.ajax({
            type: "POST",
            url: "handlers/reset_password_handler.php",
            data: values,
            success: function () {
                window.location.reload();
            },
            error: function () {
                alert("Failed to update password :(");
            }
        });
        return false;
    });

    $("#new-pw").on("keyup", function() {
        // check if password meets criteria
        if (8 > $("#new-pw").val().trim().length) {
            $("#new-pw").css("border-color", "#F00");
        }
        else {
            $("#new-pw").css("border-color", "#FFF");
        }
    });
    
    $("#new-confirm-pw").on("keyup", function() {
        var new_pw = $("#new-pw").val().trim();
        var new_confirm_pw = $("#new-confirm-pw").val().trim();

        if (new_pw !== new_confirm_pw) {
            $("#new-pw").css("border-color", "#F00");
            $("#new-confirm-pw").css("border-color", "#F00");
        }
        else if (new_pw === new_confirm_pw && 8 <= new_pw.length) {
            $("#new-pw").css("border-color", "#FFF");
            $("#new-confirm-pw").css("border-color", "#FFF");
        }
    });

    // prevent form submit on enter
    $("#deleteAccount").on("keydown", function(e) {
        return e.key != "Enter";
    });
});