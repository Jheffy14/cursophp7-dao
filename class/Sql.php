<?php

class Sql {

    private $conn;

    public function __construct() {
        try {
            $this->conn = new PDO("mysql:host=localhost;dbname=dbphp7", "root", "");
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            // Handle connection error
            echo "Connection failed: " . $e->getMessage();
        }
    }

    private function setParams($statement, $parameters = array()) {
        foreach ($parameters as $key => $value) {
            $this->setParam($statement, $key, $value);
        }
    }

    private function setParam($statement, $key, $value) {
        $statement->bindParam($key, $value);
    }

    public function query($rawQuery, $params = array()) {
        try {
            $stmt = $this->conn->prepare($rawQuery);
            $this->setParams($stmt, $params);
            $stmt->execute();
            return $stmt;
        } catch(PDOException $e) {
            // Handle query error
            echo "Query failed: " . $e->getMessage();
            return false;
        }
    }

    public function select($rawQuery, $params = array()): array {
        $stmt = $this->query($rawQuery, $params);
        if ($stmt) {
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        return array(); // or handle error as needed
    }

}

?>
