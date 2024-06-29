<?php
    session_start();
    require_once "Dao.php";

    $dao = new Dao();
    $dao->addUser($_POST['username'], $_POST['password']);