<?php
namespace Saphpi;

use Saphpi\Application;

abstract class Controller {
    /** @var \Saphpi\Middleware[] $middlewares */
    protected array $middlewares = [];

    protected function render(string $name, array $props = []): string {
        return Application::view()->renderView($name, $props);
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
}
