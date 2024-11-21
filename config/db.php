<?php
class Database {
    //private $host = "restaurante.cvgm4iqmqjrj.us-east-1.rds.amazonaws.com";
    private $host = "restaurante.cvgm4iqmqjrj.us-east-1.rds.amazonaws.com";
    private $db_name = "restaurante";
    private $username = "root"; 
    private $password = "tejada987";
    public $conn;

    public function getConnection() {
        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
        } catch(PDOException $exception) {
            echo "Error de conexión: " . $exception->getMessage();
        }

        return $this->conn;
    }
}
?>
