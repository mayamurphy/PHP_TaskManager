<?php
    session_start();
    require_once "../Dao.php";

    $dao = new Dao();
    $valid_login = $dao->validLogin($_POST['login-un'], $_POST['login-pw']);

    if ($valid_login) {
        $_SESSION['authenticated'] = "authenticated";
        $_SESSION['user_id'] = $valid_login[0]['user_id'];
        $_SESSION['username'] = $valid_login[0]['username'];
        $_SESSION['todays_progress'] = $dao->getTodaysProgress($_SESSION['user_id'])[0];

        // unset if user had previously unsuccessful logins
        if (isset($_SESSION['invalid_login'])) {
            unset($_SESSION['invalid_login']);
        }
        if (isset($_SESSION['login_inputs'])) {
            unset($_SESSION['login_inputs']);
        }

        // unset if user switches from signup to login
        if (isset($_SESSION['username_exists'])) {
            unset($_SESSION['username_exists']);
        }
        if (isset($_SESSION['signup_inputs'])) {
            unset($_SESSION['signup_inputs']);
        }
        header('Location: ../tasks.php');
        exit();
    }
    else {
        $_SESSION['invalid_login'] = true;
        $_SESSION['login_inputs'] = $_POST;
        header('Location: ../index.php');
        exit();
    }