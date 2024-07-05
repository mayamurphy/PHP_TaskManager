<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    return $dao->validLogin($_POST['login-un'], $_POST['login-pw']);