<?php
namespace Saphpi\Core;

class Application {
    private static Application $app;
    private Router $router;
    private View $view;
    private Request $request;
    private Response $response;
    private Session $session;
    private Prompt $prompt;

    public static string $ROOT_DIR;
    public bool $suppressWarning = false;

    public function __construct() {
        self::$app = $this;

        $this->view = new View();
        $this->request = new Request();
        $this->response = new Response();
        $this->router = new Router($this->request, $this->response);
        $this->session = new Session();
        $this->prompt = new Prompt();

        self::$ROOT_DIR = dirname(__DIR__);
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
