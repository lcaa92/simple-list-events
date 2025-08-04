<?php

// A simple PSR-4-like autoloader
spl_autoload_register(function ($class) {
    // Define the base directory for the namespace
    $baseDir = __DIR__ . '/';

    // Replace the namespace separator with the directory separator
    $file = $baseDir . str_replace('\\', '/', $class) . '.php';

    // If the file exists, include it
    if (file_exists($file)) {
        require_once $file;
    }
});

// A simple routing mechanism
function dispatch($routes) {
    $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
    $method = $_SERVER['REQUEST_METHOD'];

    foreach ($routes as $route => $action) {
        if ($route === $uri) {
            // The action string now includes the full namespaced class name
            list($controllerClass, $actionMethod) = explode('@', $action);

            // The class name is now fully qualified
            if (class_exists($controllerClass) && method_exists(new $controllerClass, $actionMethod)) {
                $controllerInstance = new $controllerClass();
                $controllerInstance->$actionMethod();
                return;
            }
        }
    }

    // Handle 404 Not Found
    header("HTTP/1.0 404 Not Found");
    echo "404 - Page Not Found";
}

// Include our routes file
require_once 'routes.php';

// Dispatch the request
dispatch($routes);