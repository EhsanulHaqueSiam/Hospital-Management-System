<?php

require_once __DIR__ . '/../models/db.php';

/**
 * Base Model Class
 * All models should extend this class to get database access
 */
class BaseModel {
    protected $db;

    public function __construct() {
        $this->db = Database::connect();
    }

    /**
     * Get database connection
     */
    public function getDb() {
        return $this->db;
    }

    /**
     * Execute a query
     */
    protected function query($sql) {
        return $this->db->query($sql);
    }

    /**
     * Prepare a statement
     */
    protected function prepare($sql) {
        return $this->db->prepare($sql);
    }

    /**
     * Escape string
     */
    protected function escape($value) {
        return $this->db->real_escape_string($value);
    }

    /**
     * Get last inserted ID
     */
    protected function lastInsertId() {
        return $this->db->insert_id;
    }

    /**
     * Get affected rows
     */
    protected function affectedRows() {
        return $this->db->affected_rows;
    }
}

?>
