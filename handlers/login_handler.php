<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    $valid_login = $dao->validLogin($_POST['login-un'], $_POST['login-pw']);

    if ($valid_login) {
        $_SESSION['authenticated'] = "authenticated";
        $_SESSION['user_id'] = $valid_login[0]['user_id'];
    }