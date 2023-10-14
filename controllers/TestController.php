<?php
namespace Saphpi\Controllers;

use Saphpi\Controller;
use Saphpi\Request;
use Saphpi\Validator;

class TestController extends Controller {
    public function login(): string {
        return $this->render('login', ['var' => 'Test here']);
    }

    public function handleLogin(Request $request) {
        $payload = Validator::validate($request->getBody(), [
            'username' => ['Required'],
            'password' => ['Required'],
        ]);

        if (isset($payload['errors'])) {
            echo '<pre>';
            var_dump($payload['errors']);
            echo '</pre>';
            exit;
        }

        echo '<pre>';
        var_dump($payload['validated']);
        echo '</pre>';
        exit;
    }
}
