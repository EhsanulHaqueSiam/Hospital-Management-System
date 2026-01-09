<?php
// Progga Front Controller / Explorer
// Provides a simple router to include existing procedural controllers
// and a small index to list controllers, models and views.

define('PROGGA_DIR', __DIR__);

// Helper: list files in a folder
function listFiles($dir, $ext = ''){
    $out = [];
    if (!is_dir($dir)) return $out;
    $it = new DirectoryIterator($dir);
    foreach ($it as $f){
        if ($f->isDot()) continue;
        if ($ext && $f->getExtension() !== ltrim($ext, '.')) continue;
        $out[] = $f->getFilename();
    }
    sort($out);
    return $out;
}

// Determine route from URI (attempt to be robust when placed under different base paths)
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$scriptName = $_SERVER['SCRIPT_NAME'];

// Find the Progga folder segment in the URI
$basePos = stripos($uri, '/' . basename(PROGGA_DIR));
if ($basePos !== false) {
    $relative = substr($uri, $basePos + strlen('/' . basename(PROGGA_DIR)));
} else {
    $relative = $uri;
}

$segments = array_values(array_filter(explode('/', $relative)));

// If no segment, show index page
if (count($segments) === 0) {
    $controllers = listFiles(PROGGA_DIR . '/controller', '.php');
    $models = listFiles(PROGGA_DIR . '/models', '.php');
    $views = [];
    // collect view files recursively
    $rii = new RecursiveIteratorIterator(new RecursiveDirectoryIterator(PROGGA_DIR . '/view'));
    foreach ($rii as $file) {
        if ($file->isDir()) continue;
        $views[] = str_replace(PROGGA_DIR . '/view/', '', $file->getPathname());
    }

    header('Content-Type: text/html; charset=utf-8');
    echo "<h2>Progga Explorer</h2>";
    echo "<p>Use this front controller to inspect and include existing controller scripts.</p>";
    echo "<h3>Controllers</h3><ul>";
    foreach ($controllers as $c) {
        $name = basename($c, '.php');
        $link = basename(__DIR__) . '/' . $name;
        echo "<li><a href='" . htmlspecialchars($link) . "'>" . htmlspecialchars($c) . "</a></li>";
    }
    echo "</ul>";
    echo "<h3>Models</h3><ul>";
    foreach ($models as $m) {
        echo "<li>" . htmlspecialchars($m) . "</li>";
    }
    echo "</ul>";
    echo "<h3>Views (partial list)</h3><ul>";
    foreach ($views as $v) {
        echo "<li>" . htmlspecialchars($v) . "</li>";
    }
    echo "</ul>";
    exit;
}

// Map first segment to controller file
$controllerSegment = $segments[0];

$candidates = [
    PROGGA_DIR . '/controller/' . $controllerSegment . '_controller.php',
    PROGGA_DIR . '/controller/' . $controllerSegment . '.php',
    PROGGA_DIR . '/controller/' . $controllerSegment . '_Controller.php'
];

$found = false;
foreach ($candidates as $file) {
    if (file_exists($file)) {
        // include the controller script
        require_once $file;
        $found = true;
        break;
    }
}

if (!$found) {
    header("HTTP/1.1 404 Not Found");
    echo "Controller not found for segment: " . htmlspecialchars($controllerSegment);
    exit;
}

// controller scripts typically exit or render a view; if they return, finish here
exit;
