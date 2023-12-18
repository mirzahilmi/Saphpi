<?php
namespace Saphpi\Core\Console\Commands;

use Exception;
use Saphpi\Core\Console\Command;

class Create extends Command {
    public function handle(): void {
        $this->{$this->args[0]}($this->args[1]);
    }

    private function create(string $name, string $content = ''): void {
        file_put_contents(ROOT . "/{$name}", $content);
    }

    private function migration(string $name): void {
        $lastMigration = exec('ls ' . ROOT . '/migrations | tail -1');
        if (empty($lastMigration)) {
            $this->create("migrations/0001_create_{$name}_table.up.sql");
            $this->create("migrations/0001_create_{$name}_table.down.sql");
            return;
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

    private function controller(string $name) {
        $stubContent = file_get_contents(ROOT . '/core/Console/Commands/Stubs/Controller.stub');
        if ($stubContent === false) {
            throw new Exception('Controller stub file does not exist!');
        }

        $this->create("controllers/{$name}.php", sprintf($stubContent, $name));
    }

    private function model(string $name) {
        $stubContent = file_get_contents(ROOT . '/core/Console/Commands/Stubs/Model.stub');
        if ($stubContent === false) {
            throw new Exception('Model stub file does not exist!');
        }

        $this->create("models/{$name}.php", sprintf($stubContent, $name));
    }

    private function rule(string $name) {
        $stubContent = file_get_contents(ROOT . '/core/Console/Commands/Stubs/Rule.stub');
        if ($stubContent === false) {
            throw new Exception('Rule stub file does not exist!');
        }

        $this->create("rules/{$name}.php", sprintf($stubContent, $name));
    }

    private function view(string $name) {
        $this->create("views/{$name}.sapi.php");
    }

    private function middleware(string $name) {
        $stubContent = file_get_contents(ROOT . '/core/Console/Commands/Stubs/Middleware.stub');
        if ($stubContent === false) {
            throw new Exception('Middleware stub file does not exist!');
        }

        $this->create("middlewares/{$name}.php", sprintf($stubContent, $name));
    }
}
