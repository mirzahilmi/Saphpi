<?php
namespace Saphpi;

class Router {
    private array $routes;
    private Request $request;

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function get(string $path, callable | string $callback): void {
        $this->routes['get'][$path] = $callback;
    }

    public function resolve(): ?string {
        $path = $this->request->getPath();
        $method = $this->request->getMethod();
        $callback = $this->routes[$method][$path] ?? false;
        if ($callback === false) {
            return '<h1>404 Not Found</h1>';
        }
        if (is_string($callback)) {
            $viewName = $callback;
            return $this->renderView($viewName);
        }

        return call_user_func($callback);
    }

    private function renderView(string $name): string {
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
