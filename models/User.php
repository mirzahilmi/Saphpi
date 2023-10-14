<?php
namespace Saphpi\Models;

use Saphpi\Model;

class User extends Model {
    public int $id;
    public string $email;
    public string $username;
    public string $phoneNumber;

    public function __construct(array $attributes) {
        $this->populate($attributes);
    }
}
