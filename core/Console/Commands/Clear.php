<?php
namespace Saphpi\Core\Console\Commands;

use Saphpi\Core\Console\Command;

class Clear extends Command {
    public function handle(): void {
        array_map('unlink', glob(ROOT . '/runtime/sess*'));
    }
}
