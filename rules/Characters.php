<?php
namespace Saphpi\Rules;

use Saphpi\Core\Contracts\Validation\ValidationRule;

class Characters implements ValidationRule {
    public function validate(string $attribute, mixed $value): bool {
        return is_string($value);
    }

    public function error(): string {
        return ':attribute must be a string';
    }
}
