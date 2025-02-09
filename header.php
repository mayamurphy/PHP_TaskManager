<!DOCTYPE html>
<?php 
    session_start();
    if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {}
    else {
        header("Location: index.php");
        exit();
    }

    require_once "Dao.php";
    $dao = new Dao();
    
    $_SESSION['tasks_completed_today'] = $dao->getTasksCompletedToday($_SESSION['user_id'])[0];
    $_SESSION['tasks_due_today'] = $dao->getTasksDueToday($_SESSION['user_id'])[0];
?>
<html>
    <head>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/tasks.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="js\header.js"></script>
        <script type="text/javascript" src="js\tasks.js"></script>
    </head>

    <body onload="updateProgressBar(<?php echo $_SESSION['tasks_completed_today'] .','. $_SESSION['tasks_due_today'] ?>)">
        <div class="header">
            <div id="menu-container">
                <span onclick="toggleMenu()">menu</span>
                <div id="menu">
                    <div id="username"><?php echo htmlspecialchars($_SESSION['username'])?></div>
                    <div class="dropdown-content">
                        <a href="#">Profile</a>
                        <a href="#">Settings</a>
                        <a href="logout.php">Log out</a>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="content-container">
            <div id="progress-bar-container">
                Today's Progress - 
                    <span id="progress-count-completed"><?php echo $_SESSION["tasks_completed_today"] ?></span> /
                    <span id="progress-count-total"><?php echo $_SESSION["tasks_due_today"]?></span>
                    - <span id="progress-percent">
                        0</span>%
                <div id="progress-bar">
                    <div id="progress"></div>
                </div>
            </div>
            <hr>