<?php
namespace Saphpi\Core\Console\Commands;

use Saphpi\Core\Application;
use Saphpi\Core\Console\Command;

class Serve extends Command {
    public function handle(): void {
        exec('cd ' . Application::$ROOT_DIR . '/public' . ' && php -S localhost:8080');
    }
}
