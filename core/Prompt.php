<?php
namespace Saphpi\Core;

use Saphpi\Core\Console\ArgInput;

class Prompt {
    private ArgInput $argInput;

    public function __construct() {
        $this->argInput = new ArgInput();
    }

    public function resolve(): void {
        $args = $this->argInput->getArgs();
        if (empty($args)) {
            return;
        }
        $flags = $this->argInput->getFlags();

        $className = ucwords(array_shift($args));
        $class = "\\Saphpi\\Core\\Console\\Commands\\{$className}";

        try {
            /** @var \Saphpi\Core\Console\Command */
            $command = new $class($args, $flags);
        } catch (\Throwable) {
            echo "{$className} command does not exists" . PHP_EOL;
        }

        $command->handle();
    }
}
