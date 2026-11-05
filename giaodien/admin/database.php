<?php
    include "config.php";

?>



<?php
class Database {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "website_demo";
    public $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

        if ($this->connection->connect_error) {
            die("Kết nối thất bại: " . $this->connection->connect_error);
        }
    }

    public function select($query) {
        $result = $this->connection->query($query);
        return $result;
    }

    public function insert($query) {
        $result = $this->connection->query($query);
        return $result;
    }

    public function update($query) {
        $result = $this->connection->query($query);
        return $result;
    }

    public function delete($query) {
        $result = $this->connection->query($query);
        return $result;
    }

    public function prepare($query) {
        return $this->connection->prepare($query);
    }
    public function connect() {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        return $conn;
    }
}
?>