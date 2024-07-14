<!DOCTYPE html>
<?php
    session_start();
    if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {
        header("tasks.php");
        exit();
    }

    require_once "Dao.php"
?>
<html>
    <header>
        <link rel="stylesheet" href="css\index.css">
        <script type="text/javascript" src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <script type="text/javascript" src="js\index.js"></script>
        <title>Task Manager</title>
    </header>

    <!-- Container for login/sign up -->
    <div class="login-signup-container">
    
        <!-- login-sign up slider -->
        <div class="slider">
            <button id="login-page" type="button">Login</button>
            <button id="signup-page" type="button">Sign Up</button>
        </div>

        <div class="form">
            <!-- Login form -->
            <div class="login-form-container">
                <!-- error: Invalid login  -->
                <?php
                    if (isset($_SESSION["invalid_login"]) && $_SESSION["invalid_login"]) {
                        echo "<div id='error-messages-invalid-login'>Invalid login.</div>";
                    }
                ?>
                <form id="login-form" method="POST" action="handlers/login_handler.php">
                    <div>
                        <!-- <label for="login-un">Username:</label> -->
                        <input type="text" placeholder="Enter Username" id="login-un" name="login-un"
                            value="<?php echo isset($_SESSION['login_inputs']['login-un']) ? htmlspecialchars($_SESSION['login_inputs']['login-un']) : ""; ?>">
                    </div>
                    <div>
                        <!-- <label for="login-pw">Password:</label> -->
                        <input type="password" placeholder="Enter Password" id="login-pw" name="login-pw">
                    </div>
                    <div id="submit-button">
                        <input type="submit" value="Login">
                    </div>
                </form>
            </div>
            
            <!-- Sign up form -->
            <div class="signup-form-container">
                <!-- error: username taken -->
                <?php
                    if (isset($_SESSION["username_exists"]) && $_SESSION["username_exists"]) {
                        echo "<div id='error-messages-un-taken'>Username taken.</div>";
                    }
                ?>
                <form id="signup-form" onkeyup="signupValidation()">
                    <div>
                        <!-- <label for="signup-un">Username:</label> -->
                        <input type="text" placeholder="Enter Username" id="signup-un" name="signup-un"
                        value="<?php echo isset($_SESSION['signup_inputs']['signup-un']) ? htmlspecialchars($_SESSION['signup_inputs']['signup-un']): ""?>">
                    </div>
                    <div>
                        <!-- <label for="signup-pw">Password:</label> -->
                        <input type="password" placeholder="Enter Password" id="signup-pw" name="signup-pw">
                    </div>
                    <div>
                        <!-- <label for="signup-pw">Confirm Password:</label> -->
                        <input type="password" placeholder="Confirm Password" id="signup-confirm-pw" name="signup-confirm-pw">
                    </div>
                    <div id="submit-button">
                        <input type="submit" value="Sign Up">
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>