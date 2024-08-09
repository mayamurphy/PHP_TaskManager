<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    $dao->editTask($_POST['edit-task-id'], $_SESSION['user_id'], $_POST['edit-task-name'], $_POST['edit-task-description'], $_POST['edit-task-due-date'], $_POST['edit-task-status']);