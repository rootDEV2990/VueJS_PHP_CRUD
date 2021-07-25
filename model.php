<?php
    Class Model{
        private $server = '127.0.0.1';//this is where you put the ip of your sql server
        private $username = 'root';//this is your sql user
        private $password = '';//this is for your login info
        private $db = '';//this is for your db name
        private $conn;

        public function __construct(){
            try {
                $this->conn = new mysqli($this->server, $this->username. $this->password, $this->db);
            } catch (Exception $e) {
                echo "Connection error " . $e->getMessage();
            }
        }
    }
?>