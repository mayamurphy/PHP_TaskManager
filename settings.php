<!DOCTYPE html>
        <?php require_once "header.php"?>
        <div id="settings">
            <span>settings</span>
            <hr>
            <div id="security-questions">
                <span>change security questions</span>
                <form id="securityQuestionsForm">
                    <label>Question 1:</label>
                    <select id="sqq1">
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>
                    <input type="text" id="sqa1"/>

                    <label>Question 2:</label>
                    <select id="sqq2">
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>
                    <input type="text" id="sqa2"/>

                    <label>Question 3:</label>
                    <select id="sqq3">
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                        <option></option>
                    </select>
                    <input type="text" id="sqa3"/>

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