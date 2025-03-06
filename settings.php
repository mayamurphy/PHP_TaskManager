<!DOCTYPE html>
        <?php require_once "header.php"?>
        <header>
            <script type="text/javascript" src="js\settings.js"></script>
            <title>Settings</title>
        </header>
        <div id="settings">
            <span>settings</span>
            <hr>
            <div id="security-questions">
                <span>change security questions</span>
                <form id="securityQuestionsForm">
                    <label>Question 1:</label>
                    <select id="signup-sqq1" name="signup-sqq1">
                        <!-- <option selected disabled>--- Question 1 ---</option> -->
                        <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                        <option value="What city did you grow up in?">What city did you grow up in?</option>
                        <option value="How many siblings do you have?">How many siblings do you have?</option>
                    </select>
                    <input type="text" placeholder="--- Answer 1 ---" id="signup-sqa1" name="signup-sqa1"/>

                    <label>Question 2:</label>
                    <select id="signup-sqq2" name="signup-sqq2">
                        <!-- <option selected disabled>--- Question 2 ---</option> -->
                        <option value="What is your favorite childhood book?">What is your favorite childhood book?</option>
                        <option value="What is the name of your first car?">What is the name of your first car?</option>
                        <option value="What was your first job title?">What was your first job title?</option>
                    </select>
                    <input type="text" placeholder="--- Answer 2 ---" id="signup-sqa2" name="signup-sqa2"/>

                    <label>Question 3:</label>
                    <select id="signup-sqq3" name="signup-sqq3">
                        <!-- <option selected disabled>--- Question 3 ---</option> -->
                        <option value="What is your favorite sports team?">What is your favorite sports team?</option>
                        <option value="What was your high school mascot?">What was your high school mascot?</option>
                        <option value="What is your favorite holiday?">What is your favorite holiday?</option>
                    </select>
                    <input type="text" placeholder="--- Answer 3 ---" id="signup-sqa3" name="signup-sqa3"/>

                    <button>Update Security Questions</button>
                </form>
                <hr>
            </div>
            <div id="password-reset">
                <span>password reset</span>
                <form id="passwordResetForm">
                    <input type="password" placeholder="Enter Old Password" id="old-pw" name="old-pw">
                    <input type="password" placeholder="Enter New Password" id="new-pw" name="new-pw">
                    <input type="password" placeholder="Confirm New Password" id="new-confirm-pw" name="new-confirm-pw">

                    <button>Update Password</button>
                </form>
            </div>
            <div id="delete-account">
                <hr>
                <form id="deleteAccount">
                    <button>delete account</button>
                </form>
                <hr>
            </div>
        </div>
<?php require_once 'footer.php'?>