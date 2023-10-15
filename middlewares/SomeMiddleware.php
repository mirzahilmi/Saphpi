<?php
namespace Saphpi\Middlewares;

use Saphpi\Core\Request;
use Saphpi\Core\Middleware;

class SomeMiddleware extends Middleware {
    public function execute(Request $request): void {}
}
