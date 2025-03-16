<?php
    session_start();
    require_once "../Dao.php";

    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old-pw'];
    $new_password = $_POST['new-pw'];

    $dao = new Dao();

    if ($dao->validLogin($_SESSION['username'], $old_password)) {
        $dao->updateUserPassword($user_id, $old_password, $new_password);

        if ($dao->validLogin($_SESSION['username'], $new_password)) {
            session_destroy();
            header("Location: ../index.php");
            exit();
        }
    }
    else {
        $_SESSION['error-message'] = "Old password incorrect. Unable to update password.";
        header("../settings.php");
        exit();
    }

    // shouldn't reach unless there was a system/server error
    $_SESSION['error-message'] = "An error occurred. Please contact support. Unable to update password.";
    header("../settings.php");
    exit();