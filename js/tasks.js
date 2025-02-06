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

        var name = document.getElementById("add-task-name").value;
        var due_date = document.getElementById("add-task-due-date").value;

        if ("" === name) {
            $("#add-task-name").css("border-color","#F00");
            return false;
        }
        else {
            $("#add-task-name").css("border-color","#000");
        }

        if (!Date.parse(due_date)) {
            $("#add-task-due-date").css("border-color","#F00");
            return false;
        }
        else {
            $("#add-task-due-date").css("border-color","#000");
        }

        $.ajax ({
            type: "POST",
            url: "handlers/add_task_handler.php",
            data: values,
            success: function() {
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
function openEditTaskForm(id, name, desc, due, status) {
    $("#editTaskForm").css("display","block");

    $("#edit-task-id").val(id);
    $("#edit-task-name").val(name);
    $("#edit-task-name").css("border-color","#000");
    $("#edit-task-description").val(desc);
    $("#edit-old-task-due-date").val(due);
    $("#edit-task-due-date").val(due);
    $("#edit-task-due-date").css("border-color","#000");
    $("#edit-old-task-status").val(status);
    $("#edit-task-status").val(status);
    $("#edit-task-status").css("border-color","#000");
    
    $("#display-tasks").css("display","none");
    $("#openAddTaskForm").css("display","none");
}

function closeEditTaskForm() {
    $("#editTaskForm").css("display","none");
    $("#editTaskForm")[0].reset();
    $("#display-tasks").css("display","block");
    $("#openAddTaskForm").css("display","inline");
}

// AJAX for editTaskForm
$(function() {
    $("#editTaskForm").submit(function() {
        var values = $("#editTaskForm").serialize();

        var id = document.getElementById("edit-task-id").value;
        var curr_date = document.getElementById("edit-task-curr-date").value;
        var name = document.getElementById("edit-task-name").value;
        var desc = document.getElementById("edit-task-description").value;
        var old_due_date = document.getElementById("edit-old-task-due-date").value;
        var due_date = document.getElementById("edit-task-due-date").value;
        var old_status = document.getElementById("edit-old-task-status").value;
        var status = document.getElementById("edit-task-status").value;

        if (!id) {
            alert("There was an error editing your task.");
            return false;
        }

        if ("" === name) {
            $("#edit-task-name").css("border-color","#F00");
            return false;
        }
        else {
            $("#edit-task-name").css("border-color","#000");
        }

        if (!Date.parse(due_date)) {
            $("#edit-task-due-date").css("border-color","#F00");
            return false;
        }
        else {
            $("#edit-task-due-date").css("border-color","#000");
        }

        if ("Not Started" != status && "In Progress" != status && "Completed" != status) {
            $("#edit-task-status").css("border-color","#f00");
            return false;
        }

        $.ajax ({
            type: "POST",
            url: "handlers/edit_task_handler.php",
            data: values,
            success: function() {
                if (name) {
                    $("#"+id+" #tt-name").html(name);
                }

                if (desc || due_date) {
                    $("#"+id+" #tt-desc-due").html("<p>"+desc+"</p><p>"+due_date+"</p>");
                }

                if (status) {
                    $("#"+id+" #tt-status").html(status);
                }

                /* update progress count & bar */
                var tasksCompleted = parseInt(document.getElementById("progress-count-completed").innerHTML, 10);
                var tasksDue = parseInt(document.getElementById("progress-count-total").innerHTML, 10);

                if (old_due_date !== due_date && due_date === curr_date) {
                    tasksDue++;
                    $("#progress-count-total").html(tasksDue);
                }
                else if (old_due_date !== due_date && old_due_date === curr_date) {
                    tasksDue--;
                    $("#progress-count-total").html(tasksDue);
                }

                if ("Completed" === status && "Completed" !== old_status) {       // update progress bar
                    tasksCompleted++;   // increment progress
                    
                    var perc = (tasksDue != 0) ? 100 * tasksCompleted/tasksDue : 100 + tasksCompleted;
                    var width = Math.ceil(perc / 5) * 5;        // round to nearest 5%
                    if (width > 100) { width = 100; }           // don't allow progress bar to exceed 100%
                    $("#progress-count-completed").html(tasksCompleted);    // update count for tasks completed today
                    $("#progress-percent").html(perc);          // update percent
                    $("#progress").css("width", width+"%");     // update width of progress bar
                }
                else if ("Completed" !== status && "Completed" === old_status) {
                    tasksCompleted--;   // decrement progress

                    var perc = (tasksDue != 0) ? 100 * tasksCompleted/tasksDue : 100 + tasksCompleted;
                    var width = Math.ceil(perc / 5) * 5;        // round to nearest 5%
                    if (width < 0) { width = 0; }               // don't allow progress bar to suceed 0%
                    if (width > 100) { width = 100; }           // don't allow progress bar to exceed 100%
                    $("#progress-count-completed").html(tasksCompleted);    // update count for tasks completed today
                    $("#progress-percent").html(perc);          // update percent
                    $("#progress").css("width", width+"%");     // update width of progress bar
                }

                closeEditTaskForm();
            },
            error: function () {
                alert("Failed to edit task :(");
            }
        });
        return false;
    });
});

// show/hide task desc & due date
function showExt(id) {
    $("#"+id+" #showExt").css("display", "none");
    $("#"+id+" #hideExt").css("display", "block");
    $("#"+id+" #tt-desc-due").css("display","block");
}

function hideExt(id) {
    $("#"+id+" #showExt").css("display", "block");
    $("#"+id+" #hideExt").css("display", "none");
    $("#"+id+" #tt-desc-due").css("display","none");
}