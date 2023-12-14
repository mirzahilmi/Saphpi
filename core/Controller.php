<?php
namespace Saphpi\Core;

abstract class Controller {
    /** @var \Saphpi\Middleware[] $middlewares */
    protected array $middlewares = [];

    protected Response $response;

    protected function render(string $name, array $props = [], string $title): string {
        return Application::view()->renderView($name, $props, $title);
    }

    protected function redirect(string $path): void {
        Application::response()->redirect($path);
    }

    protected function registerMiddlewares(Middleware...$middlewares): void {
        $this->middlewares = $middlewares;
    }

    /**
     * Return array of middlewares
     *
     * @return \Saphpi\Middleware[]
     */
    public function getMiddlewares(): array {
        return $this->middlewares;
    }

    public function registerResponse(Response $response): void {
        $this->response = $response;
    }
}
