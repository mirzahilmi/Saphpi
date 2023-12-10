<?php
namespace Saphpi\Core;

class Application {
    private static Application $app;
    private readonly ?Database $database;
    private readonly Router $router;
    private readonly View $view;
    private readonly Request $request;
    private readonly Response $response;
    private readonly Session $session;
    private readonly Prompt $prompt;
    public static string $ROOT_DIR;
    public bool $suppressWarning = false;

    public function __construct(Database $database = null) {
        self::$app = $this;
        self::$ROOT_DIR = dirname(__DIR__);
        $this->database = $database;
        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->prompt = new Prompt();
    }

    public static function db(): Database {
        return self::$app->database;
    }

    public static function router(): Router {
        return self::$app->router;
    }

    public static function view(): View {
        return self::$app->view;
    }

    public static function request(): Request {
        return self::$app->request;
    }

    public static function response(): Response {
        return self::$app->response;
    }

    public static function session(): Session {
        return self::$app->session;
    }

    public static function prompt(): Prompt {
        return self::$app->prompt;
    }

    public function run(): void {
        try {
            echo $this->router->resolve();
        } catch (\Throwable $e) {
            echo $this->view->error($e, $this->suppressWarning);
        }
    }
}
