<?php
namespace Saphpi\Core;

abstract class Middleware {
    private array $protectedHandlers;

    public function __construct(array $protectedHandlers = ['*']) {
        $this->protectedHandlers = $protectedHandlers;
    }

    /**
     * Execute middleware logic
     *
     * @param Request $request
     * @throws Exception
     * @return void
     */
    abstract public function execute(Request $request): void;

    public function getProtectedHandlers(): array {
        return $this->protectedHandlers;
    }
}
