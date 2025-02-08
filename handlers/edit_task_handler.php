<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    if ($dao->validTask($_POST['edit-task-id'], $_SESSION['user_id'])) {
        // update progress bar
        if ("Completed" == $_POST['edit-task-status'] && "Completed" != $_POST['edit-old-task-status']) {
            $_SESSION['todays_progress'] += 1;
        }
        else if ("Completed" != $_POST['edit-task-status'] && "Completed" == $_POST['edit-old-task-status']) {
            $_SESSION['todays_progress'] -= 1;
        }

        $dao->editTask($_POST['edit-task-id'], 
                        $_SESSION['user_id'], 
                        $_POST['edit-task-name'], 
                        $_POST['edit-task-description'], 
                        $_POST['edit-task-due-date'], 
                        $_POST['edit-task-status'], 
                        $_POST['edit-old-task-status']);
    }