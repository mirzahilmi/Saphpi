<?php
namespace Saphpi\Core;

use Saphpi\Exceptions\NotFoundException;
use Saphpi\Exceptions\NotImplementException;

class Router {
    private array $routes;
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, callable | string | array $callback): void {
        $this->routes['GET'][$path] = $callback;
    }

    public function post(string $path, callable | string | array $callback): void {
        $this->routes['POST'][$path] = $callback;
    }

    public function put(string $path, callable | string | array $callback): void {
        $this->routes['PUT'][$path] = $callback;
    }

    public function patch(string $path, callable | string | array $callback): void {
        $this->routes['PATCH'][$path] = $callback;
    }

    public function delete(string $path, callable | string | array $callback): void {
        $this->routes['DELETE'][$path] = $callback;
    }

    public function resolve(): ?string {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $instance = $this->routes[$method][$path] ?? false;
        if ($instance === false) {
            throw new NotFoundException();
        }
        if (is_string($instance)) {
            return Application::view()->renderView($instance);
        }
        if (is_array($instance)) {
            $instance[0] = new $instance[0]();
            if (!$instance[0] instanceof Controller) {
                throw new NotImplementException("{$instance[0]} does not implement Controller abstract");
            }
            $instance[0]->registerResponse($this->response);
            $this->checkForMiddlewares($instance[1], $instance[0]->getMiddlewares());
        }

        return $instance($this->request, $this->response);
    }

    /**
     * Check for handler middleware
     *
     * @param string $handler
     * @param \Saphpi\Core\Middleware[] $middlewares
     * @return void
     */
    private function checkForMiddlewares(string $handler, array $middlewares): void {
        foreach ($middlewares as $middleware) {
            $protectedHandlers = $middleware->getProtectedHandlers();
            if (!($protectedHandlers[0] === '*' || in_array($handler, $protectedHandlers))) {
                continue;
            }

            $middleware->execute($this->request);
        }
    }
}
