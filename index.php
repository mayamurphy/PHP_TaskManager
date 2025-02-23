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
                <div id='error-messages'>
                <?php
                    if (isset($_SESSION["invalid_login"]) && $_SESSION["invalid_login"]) {
                        echo "<p id='error-messages-invalid-login'>Invalid login.</p>";
                    }
                ?>
                </div>
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
                <form id="signup-form" autocomplete="off">
                    <div id="signup-un-pw">
                        
                        <!-- error: username taken -->
                        <div id='error-messages'>
                        <?php
                            if (isset($_SESSION["username_exists"]) && $_SESSION["username_exists"]) {
                                echo "<p id='error-messages-un-taken'>Username taken.</p>";
                            }
                        ?>
                        </div>
                        <div>
                            <!-- <label for="signup-un">Username:</label> -->
                            <input type="text" placeholder="Enter Username" id="signup-un" name="signup-un"
                            value="<?php echo isset($_SESSION['signup_inputs']['signup-un']) ? htmlspecialchars($_SESSION['signup_inputs']['signup-un']) : ""?>">
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
                            <p>Security Questions</p>

                            <!-- <label>Question 1:</label> -->
                            <select id="signup-sqq1" name="signup-sqq1">
                                <option selected disabled>--- Question 1 ---</option>
                                <option value="What was the name of your first pet?" 
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq1']) 
                                                            && "What was the name of your first pet?" === $_SESSION['signup_inputs']['signup-sqq1'] 
                                                                ? "selected" 
                                                                : ""?>>What was the name of your first pet?</option>
                                <option value="What city did you grow up in?"
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq1']) 
                                                            && "What city did you grow up in?" === $_SESSION['signup_inputs']['signup-sqq1'] 
                                                                ? "selected" 
                                                                : ""?>>What city did you grow up in?</option>
                                <option value="How many siblings do you have?"
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq1']) 
                                                            && "How many siblings do you have?" === $_SESSION['signup_inputs']['signup-sqq1'] 
                                                                ? "selected" 
                                                                : ""?>>How many siblings do you have?</option>
                            </select>
                            <input type="text" placeholder="--- Answer 1 ---" id="signup-sqa1" name="signup-sqa1"
                                value="<?php echo isset($_SESSION['signup_inputs']['signup-sqa1'])
                                                        ? htmlspecialchars($_SESSION['signup_inputs']['signup-sqa1'])
                                                        : ""?>"/>

                            <!-- <label>Question 2:</label> -->
                            <select id="signup-sqq2" name="signup-sqq2">
                                <option selected disabled>--- Question 2 ---</option>
                                <option value="What is your favorite childhood book?" 
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq2']) 
                                                            && "What is your favorite childhood book?" === $_SESSION['signup_inputs']['signup-sqq2'] 
                                                                ? "selected" 
                                                                : ""?>>What is your favorite childhood book?</option>
                                <option value="What is the name of your first car?" 
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq2']) 
                                                            && "What is the name of your first car?" === $_SESSION['signup_inputs']['signup-sqq2'] 
                                                                ? "selected" 
                                                                : ""?>>What is the name of your first car?</option>
                                <option value="What was your first job title?" 
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq2']) 
                                                            && "What was your first job title?" === $_SESSION['signup_inputs']['signup-sqq2'] 
                                                                ? "selected" 
                                                                : ""?>>What was your first job title?</option>
                            </select>
                            <input type="text" placeholder="--- Answer 2 ---" id="signup-sqa2" name="signup-sqa2"
                                value="<?php echo isset($_SESSION['signup_inputs']['signup-sqa2'])
                                                        ? htmlspecialchars($_SESSION['signup_inputs']['signup-sqa2'])
                                                        : ""?>"/>

                            <!-- <label>Question 3:</label> -->
                            <select id="signup-sqq3" name="signup-sqq3">
                                <option selected disabled>--- Question 3 ---</option>
                                <option value="What is your favorite sports team?" 
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq3']) 
                                                            && "What is your favorite sports team?" === $_SESSION['signup_inputs']['signup-sqq3'] 
                                                                ? "selected" 
                                                                : ""?>>What is your favorite sports team?</option>
                                <option value="What was your high school mascot?" 
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq3']) 
                                                            && "What was your high school mascot?" === $_SESSION['signup_inputs']['signup-sqq3'] 
                                                                ? "selected" 
                                                                : ""?>>What was your high school mascot?</option>
                                <option value="What is your favorite holiday?" 
                                    <?php echo isset($_SESSION['signup_inputs']['signup-sqq3']) 
                                                            && "What is your favorite holiday?" === $_SESSION['signup_inputs']['signup-sqq3'] 
                                                                ? "selected" 
                                                                : ""?>>What is your favorite holiday?</option>
                            </select>
                            <input type="text" placeholder="--- Answer 3 ---" id="signup-sqa3" name="signup-sqa3"
                                value="<?php echo isset($_SESSION['signup_inputs']['signup-sqa3'])
                                                        ? htmlspecialchars($_SESSION['signup_inputs']['signup-sqa3'])
                                                        : ""?>"/>
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