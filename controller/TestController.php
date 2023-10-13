<?php
namespace Saphpi\Controller;

use Saphpi\Controller;
use Saphpi\Request;

class TestController extends Controller {
    public function login(): string {
        return $this->render('login', ['var' => 'Test here']);
    }

    public function handleLogin(Request $request) {
        
    }
}
