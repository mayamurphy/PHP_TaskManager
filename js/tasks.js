// open/close addTaskForm
function openAddTaskForm() {
    $("#addTaskForm").css("display","block");
    $("#addTaskForm input").css("border-color","#000");
    $("#openAddTaskForm").css("display","none");
    $("#display-tasks").css("display","none");
    $("#closeAddTaskForm").css("display","inline");
};

// AJAX for AddTaskForm
$(function() {
    $("#addTaskForm").submit(function() {
        alert("add")
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

    // cancel/close addTaskForm
    $("#closeAddTaskForm").click(function() {
        $("#addTaskForm").css("display","none");
        $("#addTaskForm")[0].reset();
        $("#addTaskForm input").css("border-color","#000");
        $("#openAddTaskForm").css("display","inline");
        $("#closeAddTaskForm").css("display","none");
        $("#display-tasks").css("display","block");
    });
});

// open/close editTaskForm
function openEditTaskForm(id) {
    var name = $("tr#"+id+" td:nth-child(1)").text();
    var desc = $("tr#"+id+" td:nth-child(5) p:nth-child(1)").text();
    var dueString = $("tr#"+id+" td:nth-child(5) p:nth-child(2)").text();
    var due = dueString.substring(
                                dueString.lastIndexOf("-")+1,dueString.length)+"-"+                                // year
                                dueString.substring(dueString.indexOf(" ")+1,dueString.indexOf("-"))+"-"+          // month
                                dueString.substring(dueString.indexOf("-")+1,dueString.lastIndexOf("-"));           // day
    var completedDate = $("tr#"+id+" td:nth-child(5) p:nth-child(3)").text();
    var status = $("tr#"+id+" td:nth-child(2)").text();

    $("#editTaskForm").css("display","block");

    $("#edit-task-id").val(id);
    $("#edit-task-name").val(name);
    $("#edit-task-name").css("border-color","#000");
    $("#edit-task-description").val(desc);
    $("#edit-old-task-due-date").val(due);
    $("#edit-task-due-date").val(due);
    $("#edit-task-due-date").css("border-color","#000");
    $("#edit-old-task-status").val(status);
    $("#edit-task-completed-date").val(completedDate);
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
                    var due = 
                        due_date.substring(due_date.indexOf("-")+1,due_date.lastIndexOf("-"))+"-"+  // month
                        due_date.substring(due_date.lastIndexOf("-")+1,due_date.length)+"-"+        // day
                        due_date.substring(0,due_date.indexOf("-"));                                // year

                    $("#"+id+" #tt-desc-due").html("<p>"+desc+"</p><p>"+due+"</p>");
                }

                if (status) {
                    $("#"+id+" #tt-status").html(status);
                }

                /* update progress count & bar */
                var tasksCompleted = parseInt(document.getElementById("progress-count-completed").innerHTML, 10);
                var tasksDue = parseInt(document.getElementById("progress-count-total").innerHTML, 10);

                if (old_due_date !== due_date && due_date === curr_date) {
                    tasksDue++;
                }
                else if (old_due_date !== due_date && old_due_date === curr_date) {
                    tasksDue--;
                }

                if ("Completed" === status && "Completed" !== old_status) {
                    tasksCompleted++;   // increment progress
                }
                if ("Completed" !== status && "Completed" === old_status) {
                    tasksCompleted--;   // decrement progress
                }
                
                updateProgressBar(tasksCompleted, tasksDue);

                closeEditTaskForm();
            },
            error: function () {
                alert("Failed to edit task :(");
            }
        });
        return false;
    });

    $("#deleteTask").click(function() {
        var values = $("#editTaskForm").serialize();

        var id = document.getElementById("edit-task-id").value;
        var curr_date = document.getElementById("edit-task-curr-date").value;
        var old_due_date = document.getElementById("edit-old-task-due-date").value;
        var completedDate = document.getElementById("edit-task-completed-date").value;

        if (!id) {
            alert("There was an error deleting your task.");
            return false;
        }

        $.ajax ({
            type: "POST",
            url: "handlers/delete_task_handler.php",
            data: values,
            success: function () {
                // remove task from table
                $("tr #"+id).css("display","none");
                
                /* update progress count & bar */
                var tasksCompleted = parseInt(document.getElementById("progress-count-completed").innerHTML, 10);
                var tasksDue = parseInt(document.getElementById("progress-count-total").innerHTML, 10);

                if (old_due_date === curr_date) {
                    // decrement tasksDue
                    tasksDue--;
                }
                if (completedDate === curr_date) {
                    // decrement tasksCompleted
                    tasksCompleted--;
                }

                updateProgressBar(tasksCompleted, tasksDue);

                closeEditTaskForm();
            },
            error: function () {
                alert("Failed to delete task :(");
            }
        });
        return false;
    });

    $("#closeEditTaskForm").click(function() {
        closeEditTaskForm();
    });
});

function updateProgressBar(tasksCompleted, tasksDue) {
    $("#progress-count-total").html(tasksDue);

    var perc = 0;
    if (0 === tasksDue && tasksCompleted > 0) {
        perc = 100 * tasksCompleted;
    }
    else if (0 !== tasksDue && tasksCompleted > 0) {
        perc = 100 * tasksCompleted/tasksDue;
    }

    var width = Math.ceil(perc / 5) * 5;        // round to nearest 5%
    if (width > 100) { width = 100; }           // don't allow progress bar to exceed 100%
    if (width < 0) { width = 0; }               // don't allow progress bar to be less than 0
    $("#progress-count-completed").html(tasksCompleted);    // update count for tasks completed today
    $("#progress-percent").html(perc);          // update percent
    $("#progress").css("width", width+"%");     // update width of progress bar
}

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