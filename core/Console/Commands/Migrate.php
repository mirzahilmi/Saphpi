<?php
namespace Saphpi\Core\Console\Commands;

use Exception;
use RuntimeException;
use Saphpi\Core\Application;
use Saphpi\Core\Console\Command;

class Migrate extends Command {
    private array $migrations;
    private array $downs;

    public function handle(): void {
        $this->bindScriptNames(Application::$ROOT_DIR . '/migrations');

        Application::db()->establishConnection();

        if (in_array('--down', $this->flags, true)) {
            if (!empty($this->args)) {
                $this->drop($this->args);
            } else {
                $this->drop();
            }

            Application::db()->closeConnection();
            return;
        }

        if (in_array('--clean', $this->flags, true)) {
            $this->drop($this->args);
        }

        $this->up($this->args);
        Application::db()->closeConnection();
    }

    public function up(array $migrations = []) {
        if (!empty($migrations)) {
            $this->migrations = array_intersect_key($this->migrations, array_flip($migrations));
            if (empty($this->migrations)) {
                throw new Exception('');
            }
        }

        print 'Running migration...' . PHP_EOL;
        foreach ($this->migrations as $name => $path) {
            print "Migrating {$name}..." . PHP_EOL;
            $script = $this->readScript($path);
            Application::db()->conn()->exec($script);
        }
        print 'Migration finished...' . PHP_EOL;
    }

    private function drop(array $downs = []) {
        if (!empty($downs)) {
            $this->downs = array_intersect_key($this->downs, array_flip($downs));
        }

        print 'Dropping tables...' . PHP_EOL;
        foreach ($this->downs as $name => $path) {
            print "Dropping {$name}..." . PHP_EOL;
            $script = $this->readScript($path);
            Application::db()->conn()->exec($script);
        }
        print 'Finished dropping tables...' . PHP_EOL;
    }

    private function bindScriptNames(string $migrationDir): void {
        $scriptNames = scandir($migrationDir);
        if ($scriptNames === false) {
            throw new RuntimeException('Directory does not exists');
        }

        array_splice($scriptNames, 0, 2);

        $regex = '/(?<=\d{4}_create_)\w+(?=_table.(up|down).sql)/';
        foreach ($scriptNames as $scriptName) {
            if (!preg_match($regex, $scriptName, $matches)) {
                throw new RuntimeException("{$scriptName} is not a correct migration name!");
            }
            $tableName = $matches[0];

            if (strpos($scriptName, 'up')) {
                $this->migrations[$tableName] = "{$migrationDir}/{$scriptName}";
            } else {
                $this->downs[$tableName] = "{$migrationDir}/{$scriptName}";
            }
        }
    }

    private function readScript(string $path): string {
        if (!$content = file_get_contents($path)) {
            throw new RuntimeException("Failed to read {$path} file content");
        }

        return $content;
    }
}
