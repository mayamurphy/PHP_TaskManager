<?php
    require_once "Klogger.php";
    class Dao {
        private $host = "localhost";
        private $db = "taskmanager";
        private $user = "root";
        private $pass = "";

        protected $logger;

        public function getConnection() {
            return new PDO("mysql:host={$this->host};dbname={$this->db}", 
                                        $this->user,
                                        $this->pass);
        }

        public function __construct() {
            $this->logger = new KLogger ( "log.txt" , KLogger::DEBUG );
            $conn = $this->getConnection();
            $users_table = "CREATE TABLE IF NOT EXISTS
                            users (user_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            username VARCHAR(64) NOT NULL UNIQUE,
                            password VARCHAR(64) NOT NULL);";
            $q = $conn->prepare($users_table);
            $q->execute();

            $security_questions_table = 
                           "CREATE TABLE IF NOT EXISTS
                            security_questions (security_question_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            user_id INT NOT NULL,
                            sqq1 VARCHAR(256) NOT NULL,
                            sqa1 VARCHAR(256) NOT NULL,
                            sqq2 VARCHAR(256) NOT NULL,
                            sqa2 VARCHAR(256) NOT NULL,
                            sqq3 VARCHAR(256) NOT NULL,
                            sqa3 VARCHAR(256) NOT NULL,
                            FOREIGN KEY (user_id) REFERENCES users(user_id));";
            $q = $conn->prepare($security_questions_table);
            $q->execute();

            $tasks_table = "CREATE TABLE IF NOT EXISTS
                            tasks (task_id INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
                            user_id INT NOT NULL,
                            task_name VARCHAR(256) NOT NULL,
                            task_description VARCHAR(2056),
                            task_due_date DATE NOT NULL,
                            task_status VARCHAR(12) NOT NULL,
                            task_date_added DATETIME,
                            task_completed_date DATETIME,
                            FOREIGN KEY (user_id) REFERENCES users(user_id));";
            $q = $conn->prepare($tasks_table);
            $q->execute();
        }

        /* used for updating db */
        public function updateDB() {
            $conn = $this->getConnection();
            $saveQuery = "";
            $q = $conn->prepare($saveQuery);
            $q->execute();
        }

        /* check if username exists */
        public function usernameExists($username) {
            $conn = $this->getConnection();
            $res = $conn->query("SELECT username FROM users WHERE username = '{$username}';")->fetchAll(PDO::FETCH_ASSOC);
            
            $this->logger->LogInfo("usernameExists: [{$username}]");
            return $res ? true : false;
        }

        public function validLogin($username, $password) {
            $this->logger->LogInfo("validLogin: [{$username}], [" . date('Y-m-d H:i:s') . "]");
            if ($this->usernameExists($username)) {
                $conn = $this->getConnection();
                $res = $conn->query("SELECT * FROM users WHERE username = '{$username}';")->fetchAll(PDO::FETCH_ASSOC);
                return password_verify($password, $res[0]['password']) ? $res : false;
            }
            return false;
        }

        /* add user */
        public function addUser($username, $password, $sqq1, $sqa1, $sqq2, $sqa2, $sqq3, $sqa3) {
            /* password salt */
            $options = ['cost' => 10];
            $password = password_hash($password, PASSWORD_BCRYPT, $options);

            $conn = $this->getConnection();
            $saveQuery = "INSERT INTO users (username, password)
                            VALUES (:username, :password);";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":username", $username);
            $q->bindParam(":password", $password);
            $q->execute();

            $this->addUserSecurityQuestions($this->getUserId($username), $sqq1, $sqa1, $sqq2, $sqa2, $sqq3, $sqa3);
            
            $this->logger->LogInfo("addUser: [{$username}], [" . date('Y-m-d H:i:s') . "]");
        }

        /* get user id */
        public function getUserId($username) {
            $conn = $this->getConnection();
            $res = $conn->query("SELECT user_id FROM users WHERE username = '{$username}';")->fetchAll(PDO::FETCH_ASSOC);
            $this->logger->LogInfo("getUserId: " . $res[0]['user_id']);
            return $res[0]['user_id'];
        }

        /* add user security questions */
        public function addUserSecurityQuestions($user_id, $sqq1, $sqa1, $sqq2, $sqa2, $sqq3, $sqa3) {
            $conn = $this->getConnection();
            $saveQuery = "INSERT INTO security_questions (user_id, sqq1, sqa1, sqq2, sqa2, sqq3, sqa3)
                            VALUES (:user_id, :sqq1, :sqa1, :sqq2, :sqa2, :sqq3, :sqa3);";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":user_id", $user_id);
            $q->bindParam(":sqq1", $sqq1);
            $q->bindParam(":sqa1", $sqa1);
            $q->bindParam(":sqq2", $sqq2);
            $q->bindParam(":sqa2", $sqa2);
            $q->bindParam(":sqq3", $sqq3);
            $q->bindParam(":sqa3", $sqa3);
            $q->execute();

            $this->logger->LogInfo("addUserSecurityQuestions: [{$user_id}], [" . date('Y-m-d H:i:s') . "]");
        }

        /* update user security questions */
        public function updateUserSecurityQuestions($user_id, $sqq1, $sqa1, $sqq2, $sqa2, $sqq3, $sqa3) {
            $conn = $this->getConnection();
            $saveQuery = 
                       "UPDATE security_questions 
                        SET sqq1 = :sqq1,
                            sqa1 = :sqa1,
                            sqq2 = :sqq2,
                            sqa2 = :sqa2,
                            sqq3 = :sqq3,
                            sqa3 = :sqa3,
                        WHERE user_id = :user_id;";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":user_id", $user_id);
            $q->bindParam(":sqq1", $sqq1);
            $q->bindParam(":sqa1", $sqa1);
            $q->bindParam(":sqq2", $sqq2);
            $q->bindParam(":sqa2", $sqa2);
            $q->bindParam(":sqq3", $sqq3);
            $q->bindParam(":sqa3", $sqa3);
            $q->execute();

            $this->logger->LogInfo("updateUserSecurityQuestions: [{$user_id}], [" . date('Y-m-d H:i:s') . "]");
        }

        /* update user password */
        public function updateUserPassword($user_id, $old_password, $new_password) {
            /* verify user id, password combo */
            $conn = $this->getConnection();
            $res = $conn->query("SELECT * FROM users WHERE user_id = '{$user_id}';")->fetchAll(PDO::FETCH_ASSOC);
            if (password_verify($old_password, $res[0]['password'])) {
                /* hash & salt new password */
                $options = ['cost' => 10];
                $new_password = password_hash($new_password, PASSWORD_BCRYPT, $options);
    
                /* replace old password with new password */
                $saveQuery = "UPDATE users SET password = :new_password WHERE user_id = :user_id";
                $q = $conn->prepare($saveQuery);
                $q->bindParam(":user_id", $user_id);
                $q->bindParam(":new_password", $new_password);

                $q->execute();
                $this->logger->LogInfo("updateUserPassword: [{$user_id}], [" . date('Y-m-d H:i:s') . "]");
            }
        }

        /* delete user */
        public function deleteUser($user_id) {
            $conn = $this->getConnection();

            /* remove all tasks from user */
            $saveQuery = "DELETE FROM tasks WHERE user_id = :user_id";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":user_id", $user_id);
            $q->execute();

            /* remove security questions */
            $saveQuery = "DELETE FROM security_questions WHERE user_id = :user_id";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":user_id", $user_id);
            $q->execute();

            /* remove user */
            $saveQuery = "DELETE FROM users WHERE user_id = :user_id";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":user_id", $user_id);
            $q->execute();

            $this->logger->LogInfo("deleteUser: [{$user_id}], [" . date('Y-m-d H:i:s') . "]");
        }

        /* get all users */
        public function getAllUsers() {
            $conn = $this->getConnection();
            return $conn->query("SELECT * FROM users")->fetchAll(PDO::FETCH_ASSOC);;
        }
        
        /* add task */
        public function addTask($user_id, $name, $description, $due_date) {
            $date_added = date('Y-m-d H:i:s');
            $this->logger->LogInfo("addTask: [{$user_id}], [{$name}], [{$description}], [{$due_date}], [{$date_added}]");
            $conn = $this->getConnection();
            $saveQuery = "INSERT INTO tasks (user_id, task_name, task_description, task_due_date, task_status, task_date_added)
                            VALUES (:user_id, :task_name, :task_description, :task_due_date, 'Not Started', :task_date_added);";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":user_id", $user_id);
            $q->bindParam(":task_name", $name);
            $q->bindParam(":task_description", $description);
            $q->bindParam(":task_due_date", $due_date);
            $q->bindParam(":task_date_added",$date_added);
            $q->execute();
        }

        /* edit task */
        public function editTask($task_id, $user_id, $name, $description, $due_date, $status, $old_status) {
            $conn = $this->getConnection();
            if ("Completed" === $status) {
                $completed_date = date('Y-m-d');
                $saveQuery = "UPDATE tasks
                SET task_name = :task_name,
                    task_description = :task_description,
                    task_due_date = :task_due_date,
                    task_status = :task_status,
                    task_completed_date = :task_completed_date
                WHERE task_id = :task_id AND user_id = :user_id;";
                $q = $conn->prepare($saveQuery);
                $q->bindParam(":task_id", $task_id);
                $q->bindParam(":user_id", $user_id);
                $q->bindParam(":task_name", $name);
                $q->bindParam(":task_description", $description);
                $q->bindParam(":task_due_date", $due_date);
                $q->bindParam(":task_status", $status);
                $q->bindParam(":task_completed_date", $completed_date);
                $q->execute();
                $this->logger->LogInfo("editTask: [{$task_id}], [{$user_id}], [{$name}], [{$description}], [{$due_date}], [{$status}], [" . date('Y-m-d H:i:s') . "], [{$completed_date}]");
            }
            else {
                $saveQuery = "UPDATE tasks
                            SET task_name = :task_name,
                                task_description = :task_description,
                                task_due_date = :task_due_date,
                                task_status = :task_status,
                                task_completed_date = NULL
                            WHERE task_id = :task_id AND user_id = :user_id;";
                $q = $conn->prepare($saveQuery);
                $q->bindParam(":task_id", $task_id);
                $q->bindParam(":user_id", $user_id);
                $q->bindParam(":task_name", $name);
                $q->bindParam(":task_description", $description);
                $q->bindParam(":task_due_date", $due_date);
                $q->bindParam(":task_status", $status);
                $q->execute();
                $this->logger->LogInfo("editTask: [{$task_id}], [{$user_id}], [{$name}], [{$description}], [{$due_date}], [{$status}], [" . date('Y-m-d H:i:s') . "]");
            }    
        }

        /* valid task */
        public function validTask($task_id, $user_id) {
            $conn = $this->getConnection();
            $res = $conn->query("SELECT * FROM tasks WHERE task_id = {$task_id} AND user_id = {$user_id};")->fetchAll(PDO::FETCH_ASSOC);
            return $res;
        }

        /* delete task */
        public function deleteTask($task_id, $user_id) {
            $conn = $this->getConnection();
            $saveQuery = "DELETE FROM tasks
                WHERE task_id = :task_id AND user_id = :user_id;";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":task_id", $task_id);
            $q->bindParam(":user_id", $user_id);
            $q->execute();
            
            $this->logger->LogInfo("- deleteTask: [{$task_id}], [{$user_id}]");
        }

        public function getAllTasks($user_id) {
            $conn = $this->getConnection();
            return $conn->query("SELECT * FROM tasks WHERE user_id = '{$user_id}'")->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTasksCompletedToday($user_id) {
            $conn = $this->getConnection();
            $today = date('Y-m-d');
            return $conn->query("SELECT COUNT(*) FROM tasks WHERE user_id = '{$user_id}' AND task_completed_date = '{$today}';")->fetchAll(PDO::FETCH_COLUMN);
        }

        public function getTasksDueToday($user_id) {
            $conn = $this->getConnection();
            $today = date('Y-m-d');
            return $conn->query("SELECT COUNT(*) FROM tasks WHERE user_id = '{$user_id}' AND task_due_date = '{$today}';")->fetchAll(PDO::FETCH_COLUMN);
        }
    }