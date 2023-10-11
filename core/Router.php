<?php
namespace Saphpi;

class Router {
    private array $routes;
    private Request $request;
    private Response $response;

    public function __construct(Request $request, Response $response) {
        $this->request = $request;
        $this->response = $response;
    }

    public function get(string $path, callable | string $callback): void {
        $this->routes['get'][$path] = $callback;
    }

    public function post(string $path, callable | string $callback): void {
        $this->routes['post'][$path] = $callback;
    }

    public function resolve(): ?string {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            $this->response->setHttpStatus(404);
            return $this->renderView('error/404');
        }
        if (is_string($callback)) {
            $viewName = $callback;
            return $this->renderView($viewName);
        }

        return $callback();
    }

    public function renderView(string $name): string {
        $content = $this->getContent($name);
        $layout = $this->getLayout();
        return str_replace('{{ CONTENT }}', $content, $layout);
    }

    private function getContent(string $name): string {
        ob_start();
        include_once Application::$ROOT_DIR . "/view/{$name}.sapi.php";
        return ob_get_clean();
    }

    private function getLayout(): string {
        ob_start();
        include_once Application::$ROOT_DIR . '/view/layout/app.sapi.php';
        return ob_get_clean();
    }
}
