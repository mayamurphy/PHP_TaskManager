<?php
    session_start();
    require_once "../Dao.php";

    $username = $_POST['signup-un'];
    $password = $_POST['signup-pw'];
    $confirm_password = $_POST['signup-confirm-pw'];

    $dao = new Dao();

    if ("" === $username || $dao->usernameExists($username)) {
        return false;
    }
    else {
        $dao->addUser($_POST['signup-un'], $_POST['signup-pw']);
    }