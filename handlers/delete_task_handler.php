<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    if ($dao->validTask($_POST['edit-task-id'], $_SESSION['user_id'])) {
        $dao->deleteTask($_POST['edit-task-id'], $_SESSION['user_id']);
    }