<?php
namespace Saphpi;

use Saphpi\Application;

abstract class Controller {
    protected function render(string $name, array $props = []): string {
        return Application::router()->renderView($name, $props);
    }
}
