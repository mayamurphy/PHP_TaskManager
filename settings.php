        <?php require_once "header.php"?>
        <header>
            <link rel="stylesheet" href="css/settings.css">
            <script type="text/javascript" src="js\settings.js"></script>
            <title>Settings</title>
        </header>
        <div id="settings">
            <div>settings</div>
            <hr>
            <div id="security-questions">
                <p>change security questions</p>
                <form id="securityQuestionsForm">
                    <?php
                        $sq = $dao->getUserSecurityQuestions($_SESSION['user_id'])[0];
                        echo "<input type='hidden' id='user-id' name='user-id' value='" . $_SESSION['user_id'] . "'>";
                        echo "<p><div id='question-label'>Question 1:</div>" .
                            "<select id='settings-sqq1' name='settings-sqq1'>" .
                                "<option value='What was the name of your first pet?' 
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq1']) 
                                                            && 'What was the name of your first pet?' === $_SESSION['settings_inputs']['settings-sqq1'] 
                                                                ? 'selected' 
                                                                : ('What was the name of your first pet?' === $sq['sqq1'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">What was the name of your first pet?</option>" .
                                "<option value='What city did you grow up in?'
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq1']) 
                                                            && 'What city did you grow up in?' === $_SESSION['settings_inputs']['settings-sqq1'] 
                                                                ? 'selected' 
                                                                : ('What city did you grow up in?' === $sq['sqq1'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">What city did you grow up in?</option>" .
                                "<option value='How many siblings do you have?'
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq1']) 
                                                            && 'How many siblings do you have?' === $_SESSION['settings_inputs']['settings-sqq1'] 
                                                                ? 'selected' 
                                                                : ('How many siblings do you have?' === $sq['sqq1'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">How many siblings do you have?</option>" .
                            "</select>" .
                            "<input type='text' placeholder='--- Answer 1 ---' id='settings-sqa1' name='settings-sqa1'
                                value='" . (isset($_SESSION['settings_inputs']['settings-sqa1'])
                                                        ? htmlspecialchars($_SESSION['settings_inputs']['settings-sqa1'])
                                                        : $sq['sqa1'] ). "'/></p>" .

                            "<p><div id='question-label'>Question 2:</div>" .
                            "<select id='settings-sqq2' name='settings-sqq2'>" .
                                "<option value='What is your favorite childhood book?' 
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq2']) 
                                                            && 'What is your favorite childhood book?' === $_SESSION['settings_inputs']['settings-sqq2'] 
                                                                ? 'selected' 
                                                                : ('What is your favorite childhood book?' === $sq['sqq2'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">What is your favorite childhood book?</option>" .
                                "<option value='What is the name of your first car?' 
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq2']) 
                                                            && 'What is the name of your first car?' === $_SESSION['settings_inputs']['settings-sqq2'] 
                                                                ? 'selected' 
                                                                    : ('What is the name of your first car?' === $sq['sqq2'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">What is the name of your first car?</option>" .
                                "<option value='What was your first job title?' 
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq2']) 
                                                            && 'What was your first job title?' === $_SESSION['settings_inputs']['settings-sqq2'] 
                                                                ? 'selected' 
                                                                : ('What was your first job title?' === $sq['sqq2'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">What was your first job title?</option>" .
                            "</select>" .
                            "<input type='text' placeholder='--- Answer 2 ---' id='settings-sqa2' name='settings-sqa2'
                                value='" . (isset($_SESSION['settings_inputs']['settings-sqa2'])
                                                        ? htmlspecialchars($_SESSION['settings_inputs']['settings-sqa2'])
                                                        : $sq['sqa2'] ). "'/></p>" .

                            "<p><div id='question-label'>Question 3:</div>" .
                            "<select id='settings-sqq3' name='settings-sqq3'>" .
                                "<option value='What is your favorite sports team?' 
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq3']) 
                                                            && 'What is your favorite sports team?' === $_SESSION['settings_inputs']['settings-sqq3'] 
                                                                ? 'selected' 
                                                                : ('What is your favorite sports team?' === $sq['sqq3'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">What is your favorite sports team?</option>" .
                                "<option value='What was your high school mascot?' 
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq3']) 
                                                            && 'What was your high school mascot?' === $_SESSION['settings_inputs']['settings-sqq3'] 
                                                                ? 'selected' 
                                                                : ('What was your high school mascot?' === $sq['sqq3'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">What was your high school mascot?</option>" .
                                "<option value='What is your favorite holiday?' 
                                    " . (isset($_SESSION['settings_inputs']['settings-sqq3']) 
                                                            && 'What is your favorite holiday?' === $_SESSION['settings_inputs']['settings-sqq3'] 
                                                                ? 'selected' 
                                                                : ('What is your favorite holiday?' === $sq['sqq3'] 
                                                                    ? 'selected' 
                                                                    : '')) . ">What is your favorite holiday?</option>" .
                            "</select>" .
                            "<input type='text' placeholder='--- Answer 3 ---' id='settings-sqa3' name='settings-sqa3'
                                value='" . (isset($_SESSION['settings_inputs']['settings-sqa3'])
                                                        ? htmlspecialchars($_SESSION['settings_inputs']['settings-sqa3'])
                                                        : $sq['sqa3'] ). "'/></p>";
                            ?>
                    <button>Update Security Questions</button>
                </form>
            </div>
            <hr>
            <div id="password-reset">
                <p>password reset</p>
                <div id="password-reset-error-message">
                    <?php
                        if (isset($_SESSION['error-message'])) {
                            echo $_SESSION['error-message'];
                            unset($_SESSION['error-message']);
                        }
                    ?>
                </div>
                <form id="passwordResetForm">
                    <p>
                        <input type="password" placeholder="Enter Old Password" id="old-pw" name="old-pw">
                        <input type="password" placeholder="Enter New Password" id="new-pw" name="new-pw">
                        <input type="password" placeholder="Confirm New Password" id="new-confirm-pw" name="new-confirm-pw">
                    </p>

                    <button>Update Password</button>
                </form>
            </div>
            <hr>
            <div id="delete-account">
                <div id="delete-account-error-message">
                    <?php
                        if (isset($_SESSION['delete-account-error'])) {
                            echo $_SESSION['delete-account-error'];
                            unset($_SESSION['delete-account-error']);
                        }
                    ?>
                </div>
                <p><button id="delete-open-message">Delete Account</button></p>
                <div id="delete-account-message">
                    <p>This action cannot be undone. This will permanently delete your account, tasks, and settings.</p>
                    <p><em>To delete your account, please confirm your username.</em></p>
                    <form id="deleteAccountForm" autocomplete="off">
                        <input type="text" id="confirm-un" name="confirm-un"/>
                        <button id="delete-submit">PERMANENTLY DELETE ACCOUNT</button>
                     </form>
                    <button id="delete-cancel">Cancel</button>
                </div>
            </div>
            <hr>
        </div>
<?php require_once 'footer.php'?>