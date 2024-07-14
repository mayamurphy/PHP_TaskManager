<!DOCTYPE html>
<meta charset="UTF-8">
<?php 
    session_start();
    if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {}
    else {
        header("Location: index.php");
        exit();
    }
?>
<html>
    <head>
        <link rel="stylesheet" href="css/header.css">
    </head>

    <body>
        <div class="header">
            <div id="menu">
                <div id="username"><?php echo htmlspecialchars($_SESSION['username'])?></div>
                <div class="dropdown-content">
                    <a href="#">Profile</a>
                    <a href="#">Settings</a>
                    <a href="logout.php">Log out</a>
                </div>
            </div>
        </div>
        <hr>