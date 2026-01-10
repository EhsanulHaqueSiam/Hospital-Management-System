<?php


class BaseController {
    
    protected $session;
    protected $errors = [];
    protected $data = [];
    
    public function __construct() {
        $this->session = $_SESSION ?? [];
    }
    
    /**
     * Check if user is authenticated
     */
    protected function requireAuth() {
        if (!$this->isLoggedIn()) {
            $this->redirect('../view/admin_signin.php');
        }
    }
    
    /**
     * Check if user is admin
     */
    protected function requireAdmin() {
        if (!$this->isAdmin()) {
            $this->error('Access denied. Admin privileges required.');
            $this->redirect('../controller/notice_user_controller.php');
        }
    }
    
    /**
     * Check if user is logged in
     */
    protected function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['username']);
    }
    
    /**
     * Check if user is admin
     */
    protected function isAdmin() {
        return $this->isLoggedIn() && isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
    }
    
    /**
     * Get session value
     */
    protected function getSessionValue($key, $default = null) {
        return $_SESSION[$key] ?? $default;
    }
    
    /**
     * Set data for view
     */
    protected function view($viewPath, $data = []) {
        $this->data = array_merge($this->data, $data);
        extract($this->data);
        require_once($viewPath);
    }
    
    /**
     * Redirect to URL
     */
    protected function redirect($url) {
        header('Location: ' . $url);
        exit;
    }
    
    /**
     * Add error message
     */
    protected function error($message) {
        $this->errors[] = $message;
    }
    
    /**
     * Get all errors
     */
    protected function getErrors() {
        return $this->errors;
    }
    
    /**
     * Check if there are errors
     */
    protected function hasErrors() {
        return count($this->errors) > 0;
    }
    
    /**
     * Return JSON response
     */
    protected function json($data, $statusCode = 200) {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }
    
    /**
     * Get POST parameter
     */
    protected function getPost($key, $default = null) {
        return $_POST[$key] ?? $default;
    }
    
    /**
     * Get GET parameter
     */
    protected function getGet($key, $default = null) {
        return $_GET[$key] ?? $default;
    }
    
    /**
     * Validate request method
     */
    protected function validateMethod($method) {
        if ($_SERVER['REQUEST_METHOD'] !== $method) {
            $this->error("Invalid request method. Expected {$method}.");
            return false;
        }
        return true;
    }
}

?>
