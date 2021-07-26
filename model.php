<?php
    Class Model{
        private $server = '127.0.0.1';//this is where you put the ip of your sql server
        private $username = 'root';//this is your sql user
        private $password = '';//this is for your login info
        private $db = 'pvrbeats_chatroom';//this is for your db name
        private $conn;

        public function __construct(){
            try {
                $this->conn = new mysqli($this->server, $this->username, $this->password, $this->db);
                //$this->conn = new PDO('mysql:host='.$this->servername.';dbname=pvrbeats_chatroom',$this->username, $this->password);
            } catch (Exception $e) {
                echo "Connection error " . $e->getMessage();
            }
        }

        public function insert($username, $message){
            $query = "INSERT INTO anon_chat (username, message) VALUES ('$username', '$message')";
            if($sql = $this->conn->query($query)) {
                return true;
            }else {
                return;
            }
        }

        public function fetch(){
            $data = [];

            $query = "SELECT * FROM anon_chat";

            if ($sql = $this->conn->query($query)) {
                while($rows = mysqli_fetch_assoc($sql)){
                    $data[] = $rows;
                }
            }
            return $data;
        }
    }
?>