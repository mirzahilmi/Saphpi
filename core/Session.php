<?php
namespace Saphpi\Core;

class Session {
    private const FLASH_KEY = 'flash';

    public function __construct() {
        session_save_path(Application::$ROOT_DIR . '/runtime');
        session_start();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $_ => &$flashMessage) {
            $flashMessage['destroy'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function set(string $key, mixed $value): void {
        $_SESSION[$key] = $value;
    }

    public function get(string $key): mixed {
        return $_SESSION[$key] ?? false;
    }

    public function destroy(string $key): void {
        unset($_SESSION[$key]);
    }

    public function flash(mixed $value, string $key = 'message'): void {
        $_SESSION[self::FLASH_KEY][$key] = [
            'value'   => $value,
            'destroy' => false,
        ];
    }

    public function flashMessage(string $key = 'message'): mixed {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function __destruct() {
        $this->cleanFlashes();
    }

    private function cleanFlashes(): void {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['destroy']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }
}
