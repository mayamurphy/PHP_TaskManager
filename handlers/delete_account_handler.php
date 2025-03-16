<?php
    session_start();
    require_once "../Dao.php";

    $username = $_POST['confirm-un'];

    $dao = new Dao();

    if ($_SESSION['username'] === $username) {
        $dao->deleteUser($dao->getUserId($username));

        if (!$dao->getUserId($username)) {
            session_destroy();
            header("Location: ../index.php");
            exit();
        }
    }
    else {
        $_SESSION['delete-account-error'] = "There was an error deleting your account.";
    }
