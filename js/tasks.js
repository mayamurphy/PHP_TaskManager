// open/close addTaskForm
function openAddTaskForm() {
    $("#addTaskForm").css("display","block");
    $("#addTaskForm input").css("border-color","#000");
    $("#openAddTaskForm").css("display","none");
    $("#display-tasks").css("display","none");
    $("#closeAddTaskForm").css("display","inline");
};

$(function() {
    $("#closeAddTaskForm").click(function() {
        $("#addTaskForm").css("display","none");
        $("#addTaskForm")[0].reset();
        $("#addTaskForm input").css("border-color","#000");
        $("#openAddTaskForm").css("display","inline");
        $("#closeAddTaskForm").css("display","none");
        $("#display-tasks").css("display","block");
    });
});

// AJAX for AddTaskForm
$(function() {
    $("#addTaskForm").submit(function() {
        var values = $("#addTaskForm").serialize();

        var name = document.getElementById("task-name").value;
        var due_date = document.getElementById("task-due-date").value;

        if ("" === name) {
            $("#task-name").css("border-color","#F00");
            return false;
        }
        else {
            $("#task-name").css("border-color","#000");
        }

        if (!Date.parse(due_date)) {
            $("#task-due-date").css("border-color","#F00");
            return false;
        }
        else {
            $("#task-due-date").css("border-color","#000");
        }

        $.ajax ({
            type: "POST",
            url: "handlers/add_task_handler.php",
            data: values,
            success: function() {
                // $("#addTaskForm")[0].reset();
                window.location.reload();
            },
            error: function () {
                alert("Failed to add task :(");
            }
        });
        return false;
    });
});

// open/close editTaskForm
function openEditTaskForm(task_id) {
    $("#"+task_id).css("display","block");
    $("#tasks-table").css("display","none");
    $("#openAddTaskForm").css("display","none");
}

function closeEditTaskForm(task_id) {
    $("#"+task_id).css("display","none");
    $("#tasks-table").css("display","table");
    $("#tasks-table tr").css("display","block");
    $("#editTaskForm")[0].reset();
    $("#openAddTaskForm").css("display","inline");
}