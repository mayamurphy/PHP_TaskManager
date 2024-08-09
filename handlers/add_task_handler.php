<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    $dao->addTask($_SESSION['user_id'], $_POST['add-task-name'], $_POST['add-task-description'], $_POST['add-task-due-date']);