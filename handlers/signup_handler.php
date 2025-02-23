<?php
    session_start();
    require_once "../Dao.php";

    $username = $_POST['signup-un'];
    $password = $_POST['signup-pw'];
    $sqq1 = $_POST['signup-sqq1'];
    $sqa1 = $_POST['signup-sqa1'];
    $sqq2 = $_POST['signup-sqq2'];
    $sqa2 = $_POST['signup-sqa2'];
    $sqq3 = $_POST['signup-sqq3'];
    $sqa3 = $_POST['signup-sqa3'];

    $dao = new Dao();

    if ($dao->usernameExists($username)) {
        $_SESSION['username_exists'] = true;
        $_SESSION['signup_inputs'] = $_POST;
    }
    else {
        $dao->addUser($username, $password);

        $id = $dao->getUserId(username: $username);
        $dao->addUserSecurityQuestions($id, $sqq1, $sqa1, $sqq2, $sqa2, $sqq3, $sqa3);

        unset($_SESSION['username_exists']);
        unset($_SESSION['signup_inputs']);
    }