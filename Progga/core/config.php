<?php
/**
 * MVC Architecture Configuration
 * Central configuration file for the application
 */

// Define application constants
define('APP_PATH', __DIR__ . '/..');
define('CORE_PATH', __DIR__);
define('CONTROLLER_PATH', APP_PATH . '/controller');
define('MODEL_PATH', APP_PATH . '/models');
define('VIEW_PATH', APP_PATH . '/view');

// Database configuration
define('DB_HOST', '127.0.0.1');
define('DB_NAME', 'hospital_management');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application configuration
define('APP_NAME', 'Hospital Management System');
define('APP_VERSION', '1.0.0');
define('SESSION_TIMEOUT', 1800); // 30 minutes
define('COOKIE_DURATION', 2592000); // 30 days

// Auto-load required classes
function autoload($class) {
    $file = CORE_PATH . '/' . $class . '.php';
    if (file_exists($file)) {
        require_once($file);
        return true;
    }

    // Try lowercase filename (for systems with different naming)
    $fileLower = CORE_PATH . '/' . strtolower($class) . '.php';
    if (file_exists($fileLower)) {
        require_once($fileLower);
        return true;
    }

    // Try models
    $file = MODEL_PATH . '/' . $class . '.php';
    if (file_exists($file)) {
        require_once($file);
        return true;
    }

    // Try controllers
    $file = CONTROLLER_PATH . '/' . $class . '.php';
    if (file_exists($file)) {
        require_once($file);
        return true;
    }

    return false;
}

// Register autoloader
spl_autoload_register('autoload');

// Load core classes (lowercase filenames with underscores)
require_once(CORE_PATH . '/base_model.php');
require_once(CORE_PATH . '/base_controller.php');
require_once(CORE_PATH . '/router.php');

?>
