<?php
namespace Saphpi\Controllers;

use Saphpi\Request;
use Saphpi\Validator;
use Saphpi\Controller;
use Saphpi\Models\User;

class TestController extends Controller {
    public function login(): string {
        return $this->render('login', ['var' => 'Test here']);
    }

    public function handleLogin(Request $request) {
        $payload = Validator::validate($request->getBody(), [
            'email'    => ['Required'],
            'username' => ['Characters'],
            'password' => ['Required'],
        ]);

        if (isset($payload['errors'])) {
            echo '<pre>';
            var_dump($payload['errors']);
            echo '</pre>';
            exit;
        }

        $user = new User($payload['validated']);
    }
}
