<?php

namespace Routes;

use Responses\Response;
use Routes\Exceptions\RouterException;

/**
 * The Router class handles route registration and dispatching, now with CORS support.
 */
class Router
{
    protected array $routes = [];

    function __construct() {
        $this->registerRoutes();
    }

    /**
     * Registers the application's routes.
     *
     * This method initializes the `$routes` property with an array of route definitions,
     * mapping HTTP methods (GET, POST) to their respective controller actions.
     *
     * Routes:
     * - GET:
     *   - '' (root): controllers\HomeController@index
     *   - 'address': controllers\EventsController@index
     * - POST:
     *   - '' (root): controllers\HomeController@index
     *
     * @return void
     */
    public function registerRoutes()
    {
        $this->routes = [
            'GET' => [
                '' => 'Controllers\HomeController@index',
                'address' => 'Controllers\EventsController@index',
            ],
            'POST' => [
                '' => 'Controllers\HomeController@index',
            ]
        ];
    }

    /**
     * Dispatches the request to the correct controller action.
     * @param string $uri The URI path (without query string).
     * @param string $method The HTTP method.
     * @return Response The response object from the controller.
     * @throws RouterException If route, controller, or method is not found.
     */
    public function dispatch(): Response
    {
        $uri = trim(strtok(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '?'), '/');
        $method = $_SERVER['REQUEST_METHOD'];

        // 1. Handle CORS preflight OPTIONS requests.
        if ($method === 'OPTIONS') {
            $this->handleCorsPreflight();
            // Exit immediately after handling the preflight request.
            exit;
        }

        // 2. Validate the HTTP method.
        if (!isset($this->routes[$method])) {
            throw new RouterException("Method Not Allowed", 405);
        }

        // 3. Validate the URI path for the given method.
        if (!array_key_exists($uri, $this->routes[$method])) {
            throw new RouterException("Page Not Found", 404);
        }

        $action = $this->routes[$method][$uri];
        list($controllerClass, $actionMethod) = explode('@', $action);

        // 4. Validate controller class and method.
        if (!class_exists($controllerClass)) {
            throw new RouterException("Controller class '$controllerClass' not found.", 500);
        }

        $controllerInstance = new $controllerClass();

        if (!method_exists($controllerInstance, $actionMethod)) {
            throw new RouterException("Controller method '$actionMethod' not found.", 500);
        }

        // 5. Call the controller action.
        $response = $controllerInstance->$actionMethod();

        // 6. Add CORS headers to the final response.
        $this->addCorsHeaders();

        return $response;
    }

    /**
     * Handles the CORS preflight request by sending the appropriate headers.
     * In a real application, you would make this configurable.
     */
    protected function handleCorsPreflight()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
        header("Access-Control-Max-Age: 86400"); // Cache preflight for 1 day
        header("Content-Length: 0");
        http_response_code(204); // No Content
    }

    /**
     * Adds general CORS headers to a standard response.
     * This is called for all non-OPTIONS requests.
     */
    protected function addCorsHeaders()
    {
        header("Access-Control-Allow-Origin: *");
        header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
        header("Access-Control-Allow-Headers: Content-Type, Authorization");
    }
}
