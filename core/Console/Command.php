<?php
namespace Saphpi\Core\Console;

/**
 * Command Class
 *
 * @property string $name
 * @property string $description
 * @property array<integer, string> $args
 * @property array<integer, string|array> $flags
 */
abstract class Command {
    protected string $name;
    protected string $description;

    protected array $args;
    protected array $flags;

    /**
     * Class Constructor
     *
     * @param array<integer, string> $args
     * @param array<integer, string|array> $flags
     */
    public function __construct(array $args, array $flags) {
        $this->args = $args;
        $this->flags = $flags;
    }

    abstract public function handle(): void;
}
