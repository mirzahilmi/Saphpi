<?php
namespace Saphpi;

class Application {
    public static Application $app;
    public readonly Database $db;
    public readonly Router $router;
    public readonly Request $request;
    public readonly Response $response;
    public static string $ROOT_DIR;

    public function __construct(string $rootPath, Database &$db) {
        self::$app = $this;
        self::$ROOT_DIR = $rootPath;
        $this->db = $db;
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
    }

    public function run(): void {
        echo $this->router->resolve();
    }
}
