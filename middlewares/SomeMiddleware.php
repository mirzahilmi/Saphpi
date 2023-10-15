<?php
namespace Saphpi\Middlewares;

use Saphpi\Request;
use Saphpi\Middleware;

class SomeMiddleware extends Middleware {
    public function execute(Request $request): void {}
}
