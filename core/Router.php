<?php
namespace Saphpi;

class Router {
    private array $route;
    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function get(string $path, $callback): void {
        $this->route['get'][$path] = $callback;
    }

    public function resolve(): void {
        $uri = $this->request->getPath();
        echo "<pre>{$uri}</pre>";
    }
}