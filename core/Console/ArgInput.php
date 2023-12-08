<?php
namespace Saphpi\Core\Console;

/**
 * ArgInput Class
 *
 * @property array<integer, string> $args
 * @property array<integer, string|array> $flags
 */
class ArgInput {
    private array $args = [];
    private array $flags = [];

    public function __construct() {
        $argv ??= $_SERVER['argv'] ?? [];

        array_shift($argv);

        $this->parse($argv);
    }

    /**
     * Get all arguments
     *
     * @return array<integer, string>
     */
    public function getArgs(): array {
        return $this->args;
    }

    /**
     * Get all flags/options
     *
     * @return array<integer, string|array>
     */
    public function getFlags(): array {
        return $this->flags;
    }

    private function parse(array $tokens) {
        foreach ($tokens as $token) {
            if (str_starts_with($token, '--')) {
                $this->flags[] = $token;
            } else {
                $this->args[] = $token;
            }
        }
    }
}
