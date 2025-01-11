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
        public function addUser($username, $password) {
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
            
            $this->logger->LogInfo("addUser: [{$username}], [" . date('Y-m-d H:i:s') . "]");
        }

        /* delete user */
        public function deleteUser($user_id) {
            $conn = $this->getConnection();
            /* remove all tasks from user */
            /* remove user */
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
        public function deleteTask($task_id) {

        }

        public function getAllTasks($user_id) {
            $conn = $this->getConnection();
            return $conn->query("SELECT * FROM tasks WHERE user_id = '{$user_id}'")->fetchAll(PDO::FETCH_ASSOC);
        }

        public function getTodaysProgress($user_id) {
            $conn = $this->getConnection();
            $today = date('Y-m-d');
            return $conn->query("SELECT COUNT(*) FROM tasks WHERE user_id = '{$user_id}' AND task_completed_date = '{$today}';")->fetchAll(PDO::FETCH_COLUMN);
        }
    }