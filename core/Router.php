<?php
namespace Saphpi;

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
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, callable | string | array $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(): ?string {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $instance = $this->routes[$method][$path] ?? false;
        if ($instance === false) {
            throw new NotFoundException();
        }
        if (is_string($instance)) {
            return $this->renderView($instance);
        }
        if (is_array($instance)) {
            $instance[0] = new $instance[0]();
            if (!$instance[0] instanceof Controller) {
                throw new NotImplementException("{$instance[0]} does not implement Controller abstract");
            }
            $this->checkForMiddlewares($instance[1], $instance[0]->getMiddlewares());
        }

        return $instance($this->request, $this->response);
    }

    /**
     * Check for handler middleware
     *
     * @param string $handler
     * @param \Saphpi\Middleware[] $middlewares
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

    public function renderView(string $name, array $props = []): string {
        $content = $this->getContent($name, $props);
        $layout = $this->getLayout();
        return str_replace('{{ CONTENT }}', $content, $layout);
    }

    private function getLayout(): string {
        ob_start();
        @require_once Application::$ROOT_DIR . '/view/app.sapi.php';
        return ob_get_clean();
    }

    private function getContent(string $name, array $props): string {
        foreach ($props as $key => $value) {
            $$key = $value;
        }
        ob_start();
        @require_once Application::$ROOT_DIR . "/view/{$name}.sapi.php";
        return ob_get_clean();
    }
}
