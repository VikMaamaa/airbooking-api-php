<?php 
//  Database Connection
class DbConnect {

    private $server = 'localhost';
    private $dbname = '412Api';
    private $user = 'root';
    private $pass = '';
    public function connect() {

            $conn = new mysqli($this->server, $this->user, $this->pass, $this->dbname);
            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
                // echo "Connected successfully";
                return $conn;
            }
}

$db = new DbConnect;
$db->connect();
?>