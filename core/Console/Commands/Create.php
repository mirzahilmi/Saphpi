<?php
namespace Saphpi\Core\Console\Commands;

use Exception;
use Saphpi\Core\Application;
use Saphpi\Core\Console\Command;

class Create extends Command {
    public function handle(): void {
        $this->{$this->args[0]}($this->args[1]);
    }

    private function create(string $name): void {
        exec('touch ' . Application::$ROOT_DIR . "/{$name}");
    }

    private function migration(string $name): void {
        $lastMigration = exec('ls ' . Application::$ROOT_DIR . '/migrations | tail -1');
        if (empty($lastMigration)) {
            $this->create("migrations/0001_create_{$name}_table.up.sql");
            $this->create("migrations/0001_create_{$name}_table.down.sql");
        }

        $numberIdentifier = substr($lastMigration, 0, strpos($lastMigration, '_'));
        $numericIdentifier = intval($numberIdentifier);
        if ($numericIdentifier === 0) {
            throw new Exception('The last migration file in /migrations is not valid!');
        }

        $id = sprintf('%04d', ++$numericIdentifier);
        $this->create("migrations/{$id}_create_{$name}_table.up.sql");
        $this->create("migrations/{$id}_create_{$name}_table.down.sql");
    }
}
