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
            $this->logger->LogInfo("validLogin");
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
                            VALUE (:username, :password);";
            $q = $conn->prepare($saveQuery);
            $q->bindParam(":username", $username);
            $q->bindParam(":password", $password);
            $q->execute();
            
            $this->logger->LogInfo("addUser: [{$username}]");
        }

        /* delete user */
        public function deleteUser($user_id) {
            $conn = $this->getConnection();
            /* remove all tasks from user */
            /* remove user */
        }
        

        /* delete task */
        public function removeTask($task_id) {

        }
    }