<?php
    session_start();
    require_once "../Dao.php";

    $username = $_POST['signup-un'];
    $password = $_POST['signup-pw'];

    $dao = new Dao();

    if ($dao->usernameExists($username)) {
        $_SESSION['username_exists'] = true;
        $_SESSION['signup_inputs'] = $_POST;
    }
    else {
        $dao->addUser($username, $password);
        unset($_SESSION['username_exists']);
        unset($_SESSION['signup_inputs']);
    }