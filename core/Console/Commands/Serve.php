<?php
namespace Saphpi\Core\Console\Commands;

use Saphpi\Core\Application;
use Saphpi\Core\Console\Command;

class Serve extends Command {
    public function handle(): void {
        if (@($boot = $this->args[0])) {
            exec('cd ' . Application::$ROOT_DIR . "/{$boot}" . ' && php -S localhost:8080');
            return;
        }

        exec('cd ' . Application::$ROOT_DIR . '/public' . ' && php -S localhost:8080');
    }
}
