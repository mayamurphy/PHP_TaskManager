<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    $dao->addTask($_SESSION['user_id'], $_POST['task-name'], $_POST['task-description'], $_POST['task-due-date']);