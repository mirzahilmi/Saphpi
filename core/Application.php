<?php
namespace Saphpi;

class Application {
    public Router $router;

    public function __construct() {
        $this->router = new Router(new Request());
    }

    public function run(): void {
        $this->router->resolve();
    }
}
