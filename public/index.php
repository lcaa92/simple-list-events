<?php

use App\Responses\Response;
use App\Responses\ErrorResponse;
use App\Routes\Router;
use App\Routes\Exceptions\RouterException;


require __DIR__ . '/../vendor/autoload.php';

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
