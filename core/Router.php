<?php
namespace Saphpi;

class Router {
    private array $routes;
    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function get(string $path, callable $callback): void {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve(): void {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            echo '<h1>404 Not Found</h1>';
            exit;
        }

        echo call_user_func($callback);
    }
}
