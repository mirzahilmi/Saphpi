<?php
namespace Saphpi;

class View {
    public string $title;

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
