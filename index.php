<?php

use App\Responses\Response;
use App\Responses\ErrorResponse;
use App\Routes\Router;
use App\Routes\Exceptions\RouterException;

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

$router = new Router();

try {
    // Dispatch the request using the router.
    $response = $router->dispatch();

    // Send the response back to the client.
    if ($response instanceof Response) {
        $response->send();
    }
} catch (RouterException $e) {
    // Handle routing exceptions (e.g., 404 Not Found, 405 Method Not Allowed).
    $errorResponse = new ErrorResponse("404 - " . $e->getMessage());
    $errorResponse->send();
} catch (Exception $e) {
    // Handle any other general exceptions.
    $internalErrorResponse = new ErrorResponse("500 - Internal Server Error", 500);
    $internalErrorResponse->send();
}
