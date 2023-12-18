<?php
namespace Saphpi\Core\Console\Commands;

use Saphpi\Core\Console\Command;

class Serve extends Command {
    public function handle(): void {
        $format = 'cd %s && php -S localhost:%d';
        $dir = ROOT . '/' . @$this->flags['--test'] ?? 'public';
        $port = @$this->args[0] ?? 8080;

        exec(sprintf($format, $dir, $port));
    }
}
