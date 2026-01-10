<?php

class Router {
    
    private $routes = [];
    
   
    public function register($method, $path, $controller, $action) 
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
   
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($path, $route['path'])) {
                return $this->executeRoute($route);
            }
        }
        
        // Route not found
        http_response_code(404);
        echo "Route not found: {$method} {$path}";
        exit;
    }
    
    /**
     * Match path with route pattern
     */
    private function matchPath($path, $pattern) {
        $pattern = str_replace('/', '\\/', $pattern);
        $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '[a-zA-Z0-9_-]+', $pattern);
        return preg_match("/{$pattern}/", $path);
    }
    
    /**
     * Execute route
     */
    private function executeRoute($route) {
        $controllerClass = ucfirst($route['controller']) . 'Controller';
        $controllerFile = __DIR__ . '/../controller/' . $controllerClass . '.php';

        // If there's a class-based controller file, use it
        if (file_exists($controllerFile)) {
            require_once($controllerFile);
            $controller = new $controllerClass();
            $action = $route['action'];

            if (!method_exists($controller, $action)) {
                http_response_code(404);
                echo "Action not found: {$action}";
                exit;
            }

            $controller->$action();
            return;
        }

        // Fallback: support legacy procedural controllers named like "{name}.php" in controller folder
        $legacyFile = __DIR__ . '/../controller/' . $route['controller'] . '.php';
        if (file_exists($legacyFile)) {
            require_once($legacyFile);
            return;
        }

        http_response_code(404);
        echo "Controller not found: {$controllerClass} or legacy file {$route['controller']}.php";
        exit;
    }
}

?>
    
    private $routes = [];
    
    /**
     * Register a route
     */
    public function register($method, $path, $controller, $action) {
        $this->routes[] = [
            'method' => $method,
            'path' => $path,
            'controller' => $controller,
            'action' => $action
        ];
    }
    
    /**
     * Route current request
     */
    public function dispatch() {
        $method = $_SERVER['REQUEST_METHOD'];
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        
        foreach ($this->routes as $route) {
            if ($route['method'] === $method && $this->matchPath($path, $route['path'])) {
                return $this->executeRoute($route);
            }
        }
        
        // Route not found
        http_response_code(404);
        echo "Route not found: {$method} {$path}";
        exit;
    }
    
    /**
     * Match path with route pattern
     */
    private function matchPath($path, $pattern) {
        $pattern = str_replace('/', '\/', $pattern);
        $pattern = preg_replace('/\{[a-zA-Z_]+\}/', '[a-zA-Z0-9_-]+', $pattern);
        return preg_match("/{$pattern}/", $path);
    }
    
    /**
     * Execute route
     */
    private function executeRoute($route) {
        $controllerClass = ucfirst($route['controller']) . 'Controller';
        $controllerFile = __DIR__ . '/../controller/' . $controllerClass . '.php';

        // If there's a class-based controller file, use it
        if (file_exists($controllerFile)) {
            require_once($controllerFile);
            $controller = new $controllerClass();
            $action = $route['action'];

            if (!method_exists($controller, $action)) {
                http_response_code(404);
                echo "Action not found: {$action}";
                exit;
            }

            $controller->$action();
            return;
        }

        // Fallback: support legacy procedural controllers named like "{name}.php" in controller folder
        $legacyFile = __DIR__ . '/../controller/' . $route['controller'] . '.php';
        if (file_exists($legacyFile)) {
            require_once($legacyFile);
            return;
        }

        http_response_code(404);
        echo "Controller not found: {$controllerClass} or legacy file {$route['controller']}.php";
        exit;
    }
}

?>
