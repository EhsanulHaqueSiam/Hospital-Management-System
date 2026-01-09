<?php
/**
 * Base Model Class
 * All models should extend this class for consistent database operations
 */

class BaseModel {
    
    protected $connection;
    protected $errors = [];
    
    public function __construct() {
        $this->connection = $this->getConnection();
    }
    
    /**
     * Get database connection
     */
    protected function getConnection() {
        $host = "127.0.0.1";
        $dbname = "hospital_management";
        $dbuser = "root";
        $dbpass = "";
        
        $conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        mysqli_set_charset($conn, "utf8mb4");
        return $conn;
    }
    
    /**
     * Escape string for database
     */
    protected function escape($value) {
        return mysqli_real_escape_string($this->connection, $value);
    }
    
    /**
     * Execute query
     */
    protected function query($sql) {
        $result = mysqli_query($this->connection, $sql);
        
        if (!$result && mysqli_errno($this->connection) != 0) {
            $this->errors[] = "Database error: " . mysqli_error($this->connection);
            return false;
        }
        
        return $result;
    }
    
    /**
     * Fetch all results
     */
    protected function fetchAll($sql) {
        $result = $this->query($sql);
        if (!$result) return [];
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    
    /**
     * Fetch single result
     */
    protected function fetchOne($sql) {
        $result = $this->query($sql);
        if (!$result) return null;
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Get last insert ID
     */
    protected function lastInsertId() {
        return mysqli_insert_id($this->connection);
    }
    
    /**
     * Get affected rows
     */
    protected function affectedRows() {
        return mysqli_affected_rows($this->connection);
    }
    
    /**
     * Add error
     */
    protected function error($message) {
        $this->errors[] = $message;
    }
    
    /**
     * Get errors
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Check if there are errors
     */
    public function hasErrors() {
        return count($this->errors) > 0;
    }
    
    /**
     * Clear errors
     */
    public function clearErrors() {
        $this->errors = [];
    }
    
    /**
     * Close connection
     */
    public function closeConnection() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}

?>
    protected $errors = [];
    
    public function __construct() {
        $this->connection = $this->getConnection();
    }
    
    /**
     * Get database connection
     */
    protected function getConnection() {
        $host = "127.0.0.1";
        $dbname = "hospital_management";
        $dbuser = "root";
        $dbpass = "";
        
        $conn = mysqli_connect($host, $dbuser, $dbpass, $dbname);
        
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        
        mysqli_set_charset($conn, "utf8mb4");
        return $conn;
    }
    
    /**
     * Escape string for database
     */
    protected function escape($value) {
        return mysqli_real_escape_string($this->connection, $value);
    }
    
    /**
     * Execute query
     */
    protected function query($sql) {
        $result = mysqli_query($this->connection, $sql);
        
        if (!$result && mysqli_errno($this->connection) != 0) {
            $this->errors[] = "Database error: " . mysqli_error($this->connection);
            return false;
        }
        
        return $result;
    }
    
    /**
     * Fetch all results
     */
    protected function fetchAll($sql) {
        $result = $this->query($sql);
        if (!$result) return [];
        
        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
    
    /**
     * Fetch single result
     */
    protected function fetchOne($sql) {
        $result = $this->query($sql);
        if (!$result) return null;
        
        return mysqli_fetch_assoc($result);
    }
    
    /**
     * Get last insert ID
     */
    protected function lastInsertId() {
        return mysqli_insert_id($this->connection);
    }
    
    /**
     * Get affected rows
     */
    protected function affectedRows() {
        return mysqli_affected_rows($this->connection);
    }
    
    /**
     * Add error
     */
    protected function error($message) {
        $this->errors[] = $message;
    }
    
    /**
     * Get errors
     */
    public function getErrors() {
        return $this->errors;
    }
    
    /**
     * Check if there are errors
     */
    public function hasErrors() {
        return count($this->errors) > 0;
    }
    
    /**
     * Clear errors
     */
    public function clearErrors() {
        $this->errors = [];
    }
    
    /**
     * Close connection
     */
    public function closeConnection() {
        if ($this->connection) {
            mysqli_close($this->connection);
        }
    }
}

?>
