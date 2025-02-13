<!DOCTYPE html>
<?php
    session_start();
    if (isset($_SESSION["authenticated"]) && $_SESSION["authenticated"]) {
        header("Location: tasks.php");
        exit();
    }
?>

<html>
    <header>
        <link rel="stylesheet" href="css\index.css">
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
                <form id="signup-form">
                    <div id="signup-un-pw">
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
                        <div id="next-button-container">
                            <input id="next-button" type="button" value="next" disabled>
                        </div>
                    </div>

                    <div id="signup-sq">
                        <div id="security-questions">
                            <label>Question 1:</label>
                            <select id="sqq1">
                                <option>What was the name of your first pet?</option>
                                <option>What is your mother's maiden name?</option>
                                <option>What was the street name of your childhood home?</option>
                                <option>What is your oldest sibling's middle name?</option>
                                <option>What was the name of your first high school teacher?</option>
                            </select>
                            <input type="text" id="sqa1"/>

                            <label>Question 2:</label>
                            <select id="sqq2">
                                <option>What is your favorite childhood book?</option>
                                <option>What is the name of your first car?</option>
                                <option>What city did you grow up in?</option>
                                <option>What was your first job title?</option>
                                <option>What is your favorite sports team?</option>
                            </select>
                            <input type="text" id="sqa2"/>

                            <label>Question 3:</label>
                            <select id="sqq3">
                                <option>What was your high school mascot?</option>
                                <option>What is your spouse's middle name?</option>
                                <option>What is your favorite childhood holiday tradition?</option>
                                <option>What is the name of your first email address?</option>
                                <option>What was the name of your first pet as an adult?</option>
                            </select>
                            <input type="text" id="sqa3"/>
                        </div>
                        <div id="submit-button">
                            <input type="submit" value="Sign Up">
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</html>