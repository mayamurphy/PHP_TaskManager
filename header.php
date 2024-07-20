<!DOCTYPE html>
<meta charset="UTF-8">
<?php 
    session_start();
    if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {}
    else {
        header("Location: index.php");
        exit();
    }

    require_once "Dao.php";
    $dao = new Dao();
?>
<html>
    <head>
        <link rel="stylesheet" href="css/header.css">
        <link rel="stylesheet" href="css/tasks.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="js\header.js"></script>
        <script type="text/javascript" src="js\tasks.js"></script>
    </head>

    <body>
        <div class="header">
            <div id="menu-container">
                menu
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
                Progress bar
                <div id="progress-bar">
                    <div id="progress"></div>
                </div>
            </div>
            <hr>