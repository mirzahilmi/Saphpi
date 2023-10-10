<?php
namespace Saphpi;

class Application {
    public static Application $app;
    public Router $router;
    public static string $ROOT_DIR;

    public function __construct(string $rootPath) {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->router = new Router(new Request());
    }

    public function run(): void {
        echo $this->router->resolve();
    }
}
