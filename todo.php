<!DOCTYPE html>
<?php 
    session_start();
    if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {}
    else {
        header("index.php");
        exit();
    }
?>
<html>
    <h1>HELLO</h1>
</html>