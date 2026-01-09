<?php
/**
 * Session & Cookie Management Helper
 * Handles secure session initialization, cookies, and session timeouts
 */

class SessionHelper {
    const SESSION_TIMEOUT = 1800; // 30 minutes
    const COOKIE_DURATION = 2592000; // 30 days
    const COOKIE_NAME = 'hospital_auth';
    
    /**
     * Initialize secure session
     */
    public static function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            // Set secure session configuration
            ini_set('session.cookie_httponly', 1);
            ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
            ini_set('session.use_strict_mode', 1);
            ini_set('session.use_only_cookies', 1);
            
            session_start();
            
            // Initialize session timeout
            if (!isset($_SESSION['CREATED'])) {
                $_SESSION['CREATED'] = time();
            }
        }
    }
    
    /**
     * Check if session is valid and not expired
     */
    public static function isSessionValid() {
        if (!isset($_SESSION['CREATED'])) {
            return false;
        }
        
        // Check session timeout
        if (time() - $_SESSION['CREATED'] > self::SESSION_TIMEOUT) {
            self::destroySession();
            return false;
        }
        
        return true;
    }
    
    /**
     * Set login session and optional persistent cookie
     */
    public static function setLoginSession($username, $email, $role, $userId, $rememberMe = false) {
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;
        $_SESSION['user_id'] = $userId;
        $_SESSION['CREATED'] = time();
        $_SESSION['LAST_ACTIVITY'] = time();
        
        // Regenerate session ID for security
        session_regenerate_id(true);
        
        // Set persistent cookie if "Remember Me" is checked
        if ($rememberMe) {
            self::setAuthCookie($username, $email, $userId);
        }
    }
    
    /**
     * Set persistent authentication cookie
     */
    public static function setAuthCookie($username, $email, $userId) {
        $cookieData = json_encode([
            'username' => $username,
            'email' => $email,
            'user_id' => $userId,
            'token' => hash('sha256', $username . $email . time())
        ]);
        
        setcookie(
            self::COOKIE_NAME,
            $cookieData,
            time() + self::COOKIE_DURATION,
            '/',
            '',
            isset($_SERVER['HTTPS']),
            true
        );
    }
    
    /**
     * Verify and restore session from cookie
     */
    public static function verifyAuthCookie() {
        if (isset($_COOKIE[self::COOKIE_NAME])) {
            $cookieData = json_decode($_COOKIE[self::COOKIE_NAME], true);
            
            if ($cookieData && isset($cookieData['username'], $cookieData['user_id'])) {
                // Auto-login from cookie
                $_SESSION['username'] = $cookieData['username'];
                $_SESSION['email'] = $cookieData['email'];
                $_SESSION['user_id'] = $cookieData['user_id'];
                $_SESSION['role'] = 'Admin';
                $_SESSION['CREATED'] = time();
                $_SESSION['LAST_ACTIVITY'] = time();
                
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Check user authentication
     */
    public static function isUserLoggedIn() {
        return isset($_SESSION['user_id']) && 
               isset($_SESSION['username']) && 
               isset($_SESSION['role']) &&
               self::isSessionValid();
    }
    
    /**
     * Check if user is admin
     */
    public static function isAdmin() {
        return self::isUserLoggedIn() && $_SESSION['role'] === 'Admin';
    }
    
    /**
     * Update last activity time
     */
    public static function updateActivity() {
        $_SESSION['LAST_ACTIVITY'] = time();
    }
    
    /**
     * Destroy session and cookies
     */
    public static function destroySession() {
        // Destroy cookie
        setcookie(self::COOKIE_NAME, '', time() - 3600, '/');
        
        // Destroy session
        $_SESSION = array();
        
        if (ini_get("session.use_cookies")) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(),
                '',
                time() - 42000,
                $params["path"],
                $params["domain"],
                $params["secure"],
                $params["httponly"]
            );
        }
        
        session_destroy();
    }
}

?>
