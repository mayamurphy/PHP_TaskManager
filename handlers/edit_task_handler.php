<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    if ($dao->validTask($_POST['edit-task-id'], $_SESSION['user_id'])) {
        if ("Completed" == $_POST['status']) { $_SESSION['todays_progress'] += 1; } // update progress bar
        $dao->editTask($_POST['edit-task-id'], $_SESSION['user_id'], $_POST['edit-task-name'], $_POST['edit-task-description'], $_POST['edit-task-due-date'], $_POST['edit-task-status']);
    }