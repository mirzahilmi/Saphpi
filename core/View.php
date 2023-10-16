<?php
namespace Saphpi\Core;

class View {
    public string $title;

    public function error(\Throwable $e, bool $suppress): string {
        $code = !empty($e->getCode()) ? $e->getCode() : 500;
        Application::response()->setHttpStatus($code);

        if ($suppress) {
            return $this->renderView("error/$code");
        }
        return $this->renderView("error/$code", ['error' => $e->getMessage()]);
    }

    public function renderView(string $name, array $props = []): string {
        $content = $this->getContent($name, $props);
        $layout = $this->getLayout();
        return str_replace('<Content></Content>', $content, $layout);
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
