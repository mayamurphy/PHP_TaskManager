<?php
    session_start();
    require_once "../Dao.php";

    $user_id = $_POST['user-id'];
    $sqq1 = $_POST['settings-sqq1'];
    $sqa1 = $_POST['settings-sqa1'];
    $sqq2 = $_POST['settings-sqq2'];
    $sqa2 = $_POST['settings-sqa2'];
    $sqq3 = $_POST['settings-sqq3'];
    $sqa3 = $_POST['settings-sqa3'];

    $dao = new Dao();

    $dao->updateUserSecurityQuestions($user_id, $sqq1, $sqa1, $sqq2, $sqa2, $sqq3, $sqa3);